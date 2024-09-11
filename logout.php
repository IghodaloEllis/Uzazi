<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Logging Out</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 text-center">
                <h2>Goodbye!</h2>
                <p>You will be redirected to the login page in 10 seconds.</p>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 10000); // 10 seconds
    </script>
</body>
</html>