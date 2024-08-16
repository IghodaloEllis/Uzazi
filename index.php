
<!DOCTYPE html>
<html>
<head>
    <title>Welcome - Uzazi Learning Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome to Uzazi Learning Platform</h1>
    </header>

    <main>
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>

        <p>New user? <a href="register.php">Register</a></p>
    </main>

    <footer>
        &copy; Your Learning Platform <?php echo date('Y'); ?>
    </footer>
</body>
</html>
