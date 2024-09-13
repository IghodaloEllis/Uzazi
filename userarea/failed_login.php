<!DOCTYPE html>
<html>
<head>
    <title>Login Failed</title>
</head>
<body>
    <h1>Login Failed</h1>
    <p>Invalid credentials. Please try again.</p>
    <p>Redirecting to login page in 5 seconds...</p>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 5000);
    </script>
</body>
</html>