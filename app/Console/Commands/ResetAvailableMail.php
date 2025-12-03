<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\MailAvailable; 
use App\Models\Plan;
use App\Models\PlanOrder; 
use Carbon\Carbon;
class ResetAvailableMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:reset-available'; // FIXED → used in kernel & manual run
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset available_mail = total_mail every day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to reset available_mail counts...');

        try {
            $all_mail= MailAvailable::all();
            foreach($all_mail as $order){
                $order_plan=PlanOrder::where('id','=',$order->order_id)->first();
                $plan=Plan::where('id','=',$order_plan->plan_id)->first();
                if($plan->slug =='trial') continue;

                $expiryDate = Carbon::parse($order_plan->created_at)->addDays($plan->duration);
                $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate);
                if($isValid){
                    MailAvailable::where('order_id','=',$order->order_id)->update([
                'available_mail' => DB::raw('total_mail'),
            ]);

            
                }
                else{
                    continue;
                }
            }
            $this->info(' available_mail updated successfully!');
            Log::info('available_mail updated successfully at ' . now());

            return Command::SUCCESS;
           
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
