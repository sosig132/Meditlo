<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>
    <p>Thank you for registering! Please click the link below to verify your email address:</p>
    <a href="{{ url('/confirm', $token) }}">Verify Email Address</a>
    <p>If you did not create an account, no further action is required.</p>
</body>
</html> 