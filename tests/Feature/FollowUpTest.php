<?php

namespace Tests\Feature;

use App\Models\MailMessage;
use App\Models\PlanOrder;
use App\Models\User;
use App\Models\UserMailHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class FollowUpTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'mail.site_inbox'  => 'inbox@gpsites.io',
            'mail.admin_email' => 'admin@gpsites.io',
            'followups.enabled' => true,
            'followups.days'    => [3, 5],
        ]);
        DB::table('plans')->insert(['id' => 1, 'name' => 'Starter', 'slug' => 'starter', 'price' => 198, 'duration' => 30, 'mail_available' => 100, 'created_at' => now(), 'updated_at' => now()]);
        $this->user = User::factory()->create(['name' => 'Asha Rao', 'email' => 'asha@example.com']);
        PlanOrder::create(['user_id' => $this->user->id, 'plan_id' => 1, 'amount' => 198, 'duration' => 30,
            'currency' => 'USD', 'status' => 'completed', 'expire_at' => now()->addDays(20)]);
    }

    private function thread(string $type, int $daysAgo, array $replies = []): UserMailHistory
    {
        $t = UserMailHistory::create([
            'user_id' => $this->user->id, 'site_url' => 'https://example-blog.com',
            'subject' => 'Guest post offer for example-blog.com', 'message' => 'x', 'status' => 1,
            'reply_token' => Str::lower(Str::random(12)), 'blog_email' => 'owner@example-blog.com',
            'blog_id' => 1, 'mail_type' => $type,
        ]);
        $t->forceFill(['created_at' => now()->subDays($daysAgo)])->save();
        $t->messages()->create([
            'direction' => 'initial', 'from_email' => 'inbox+x@gpsites.io', 'to_emails' => ['owner@example-blog.com'],
            'bcc_emails' => ['asha@example.com', 'admin@gpsites.io'], 'subject' => $t->subject,
            'body_html' => '<p>My offer is <b>$50</b></p>', 'message_id' => 'orig-' . $t->id . '@gpsites.io',
            'status' => 'sent', 'sent_at' => now()->subDays($daysAgo),
        ]);
        foreach ($replies as $direction) {
            $t->messages()->create(['direction' => $direction, 'from_email' => 'owner@example-blog.com', 'status' => 'forwarded']);
        }
        return $t->fresh();
    }

    public function test_follow_up_rules(): void
    {
        Mail::fake();

        $due      = $this->thread('offer', 4);
        $notDue   = $this->thread('offer', 1);
        $replied  = $this->thread('order', 5, ['blog_reply']);
        $tooOld   = $this->thread('campaign', 40);

        $this->artisan('mail:send-followups')->assertSuccessful();

        // Only the due thread got a follow-up
        Mail::assertSentCount(1);
        Mail::assertSent(\App\Mail\MailWithAttachment::class, function ($m) {
            return $m->hasTo('owner@example-blog.com')
                && $m->subject === 'Re: Guest post offer for example-blog.com'
                && str_contains($m->messageBody, 'following up on my guest post offer for example-blog.com')
                && str_contains($m->messageBody, 'My offer is <b>$50</b>'); // original quoted below
        });

        $due->refresh();
        $this->assertSame(1, (int) $due->followups_sent);
        $this->assertNull($due->followups_stopped_at);
        $fu = MailMessage::where('user_mail_history_id', $due->id)->where('direction', 'follow_up')->first();
        $this->assertNotNull($fu);
        $this->assertStringNotContainsString('My offer is', $fu->body_html); // portal shows the follow-up only
        $this->assertSame('orig-' . $due->id . '@gpsites.io', $fu->in_reply_to);

        $this->assertSame(0, (int) $notDue->fresh()->followups_sent);
        $this->assertSame('replied', $replied->fresh()->followups_stop_reason);
        $this->assertSame('too_old', $tooOld->fresh()->followups_stop_reason);

        // Running again the same day sends nothing new
        $this->artisan('mail:send-followups')->assertSuccessful();
        Mail::assertSentCount(1);

        // 5 days later the second (last) follow-up goes out, then the thread is completed
        $this->travel(5)->days();
        $this->artisan('mail:send-followups')->assertSuccessful();
        $due->refresh();
        $this->assertSame(2, (int) $due->followups_sent);
        $this->assertSame('completed', $due->followups_stop_reason);
        Mail::assertSent(\App\Mail\MailWithAttachment::class, fn ($m) => str_contains($m->messageBody, 'one last time'));

        // A reply after a follow-up stops the thread
        $notDue->messages()->create(['direction' => 'blog_reply', 'from_email' => 'owner@example-blog.com', 'status' => 'forwarded']);
        $this->artisan('mail:send-followups')->assertSuccessful();
        $this->assertSame('replied', $notDue->fresh()->followups_stop_reason);
    }

    public function test_expired_plan_and_user_stop(): void
    {
        Mail::fake();
        $t = $this->thread('offer', 4);

        // Customer presses Stop
        $this->actingAs($this->user)->post(route('mail.stop-followups', $t->id))->assertRedirect();
        $this->assertSame('user_stopped', $t->fresh()->followups_stop_reason);

        // Another customer cannot stop someone else's thread
        $other = User::factory()->create();
        $t2 = $this->thread('offer', 4);
        $this->actingAs($other)->post(route('mail.stop-followups', $t2->id))->assertNotFound();

        // Expired plan: no mail, thread stopped
        PlanOrder::query()->update(['expire_at' => now()->subDay()]);
        $this->artisan('mail:send-followups')->assertSuccessful();
        Mail::assertNothingSent();
        $this->assertSame('plan_expired', $t2->fresh()->followups_stop_reason);
    }

    public function test_switch_off(): void
    {
        Mail::fake();
        config(['followups.enabled' => false]);
        $this->thread('offer', 4);
        $this->artisan('mail:send-followups')->assertSuccessful();
        Mail::assertNothingSent();
    }
}
