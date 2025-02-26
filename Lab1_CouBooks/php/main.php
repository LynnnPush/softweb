<?php
// main.php

// Include the Greeter class
use php\ConnectDb;
use php\Greeter;

require_once 'Greeter.php';
require_once  'ConnectDb.php';

// Create an instance of the Greeter class
$greeter = new Greeter();

// Connect to the database
$db = ConnectDb::getInstance();
$conn = $db->getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Greeter Page</title>
</head>
<body>
<section>
    <header>
        <!-- Display a random greeting in the header -->
        <h1><?php echo $greeter->getGreeting(); ?></h1>
    </header>
    <!-- You can add more content here -->
</section>
</body>
</html>
