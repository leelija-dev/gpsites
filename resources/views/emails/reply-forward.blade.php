<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto">
    <p><strong>{{ $blogName }}</strong> wrote about <a href="{{ $siteUrl }}">{{ $siteUrl }}</a>:</p>
    <div style="border-left:3px solid #2563eb;padding-left:12px;margin:16px 0">{!! $body !!}</div>
    <p style="font-size:12px;color:#6b7280">Reply to this email to continue the conversation via {{ config('app.name') }}.</p>
</div>