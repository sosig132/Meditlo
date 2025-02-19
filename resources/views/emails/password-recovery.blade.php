
<html>
<head>
    <title>Password Recovery</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>
    <p>Click the link below to reset your password:</p>
    <a href="{{ url('/reset-password', $token) }}">Reset Password</a>
</body>
</html>
