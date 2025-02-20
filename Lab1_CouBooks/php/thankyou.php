<?php
// Start the session first
session_start();

// Then unset and destroy
if (session_status() === PHP_SESSION_ACTIVE) {
    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}

// Rest of your thankyou.php code...
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You!</title>
</head>
<body>
<h1>Thank you for your reservation!</h1>
<p>We will send a confirmation email shortly.</p>
</body>
</html>
