<!DOCTYPE html>
<html>
<body>
    <p>Hi {{ $userName }},</p>

    <p>Your plan <strong>{{ $planName }}</strong> will expire on:
        <strong>{{ $expiryDate }}</strong>
    </p>

    <p>Please renew to continue service.</p>

    <p>Thank you!<br>{{ config('app.name') }}</p>
</body>
</html>
