<?php
include 'config/database.php';

// Include reCAPTCHA script
//echo '<script src="https://www.google.com/recaptcha/api.js"></script>';


// Generate a random verification code
function generateVerificationCode() {
    return bin2hex(random_bytes(16));
}

// Check if the verification code was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['verification_code'];
    $storedCode = $_SESSION['verification_code'];
    //$recaptchaResponse = $_POST['g-recaptcha-response'];

    if ($enteredCode === $storedCode) {
        // Verification successful, update user status or redirect to dashboard
        // ...
        echo "Verification successful!";
    } else {
        echo "Invalid verification code.";
    }
} else {
    // Generate and store the verification code in the session
    $verificationCode = generateVerificationCode();
    $_SESSION['verification_code'] = $verificationCode;

    // Send the verification code to the user's email
    // ... (using your email sending library)
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
   <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
</head>
<body>
    <h2>Verify Email</h2>
    <p>A verification code has been sent to your registered email address. Please enter the code below to complete the verification process.</p>

    <form method="post" action="verify_email.php">
        <label for="verification_code">Verification Code:</label>
        <input type="text" name="verification_code" required><br><br>
        <!--<div class="g-recaptcha" data-sitekey="your_site_key"></div>-->
        <input type="submit" value="Verify">
    </form>
</body>
</html>