<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Custom Email Verification</h1>
    <p>Hello, {{ $user->name }}</p>
    <p>Click the button below to verify your email address:</p>
    <a href="{{ $actionUrl }}" class="btn btn-primary">Verify Email</a>
</body>
</html>
