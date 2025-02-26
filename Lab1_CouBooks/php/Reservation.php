<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use php\ConnectDb;
use php\Shop;

require_once 'Shop.php';
require_once 'ConnectDb.php';



// Function to clear session and redirect
function clearSessionAndRedirect() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();
    header('Location: Reservation.php');
    exit;
}

try {
    // Connect to the database
    $db = ConnectDb::getConnection();   //PDO

    // Instantiate the Shop controller
    $shop = new Shop($db);

    // If form is submitted (POST), process the current step
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $shop->processStep($_POST);

        // If we've just moved beyond the final step (step 3), store the order
        if ($shop->getStep() > 3) {
            $shop->storeOrder();
            clearSessionAndRedirect();
        }
    }

    // Determine which step we are on
    $currentStep = $shop->getStep();

} catch (Exception $e) {
    // Log the error (you may want to implement proper logging)
    error_log("Error in Reservation.php: " . $e->getMessage());

    // Clear session and redirect on any error
    clearSessionAndRedirect();
}

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CouBooks</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="Reservation.css">
</head>

<body>
<!-- FIRST PART: header + nav side by side in a blue box -->
<div class="top-part">
    <header>
        <h1>CouBooks</h1>
        <h2>A Webtech demo site</h2>
    </header>
    <nav>
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="#">COURSES</a></li>
            <li><a href="#">RESERVATION</a></li>
            <li><a href="#">ABOUT</a></li>
        </ul>
    </nav>
</div>

<!-- SECOND PART: main content -->
<div class="middle-part">
    <main>

        <!-- STEP 1: WHO ARE YOU -->
        <section id="step1">
            <?php if ($currentStep === 1): ?>
            <form method="post" action="">
                <h2>STEP 1: WHO ARE YOU</h2>
                <p>Please provide some info about you, so we can search for the books you need.</p>

                <p>
                    <label for="fase">Fase:</label>
                    <select name="fase" id="fase">
                        <option value="firstBachelor">First Bachelor</option>
                        <option value="secondBachelor">Second Bachelor</option>
                        <option value="master">Master</option>
                        <!-- Add more options as needed -->
                    </select>
                </p>

                <p>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required />
                </p>

                <button id="step1_btn" type="button">Next...</button>
            </form>
            <!-- Welcome message -->
            <div id="welcomeMsg">

            </div>
        </section>

        <!-- STEP 2: WHAT BOOKS DO YOU NEED? -->
        <section id="step2">
            <?php elseif ($currentStep === 2): ?>
            <form method="post" action="">

                <h2>STEP 2: WHAT BOOKS DO YOU NEED?</h2>
                <p>Select the books you wish to order.</p>

                <p>
                    <input type="checkbox" id="book1" name="books[]" value="3" />
                    <label for="book1">Computer Networking: a top down approach</label>
                </p>

                <p>
                    <input type="checkbox" id="book2" name="books[]" value="2" />
                    <label for="book2">Biotechnology</label>
                </p>

                <button id="step2_btn" type="submit">Next...</button>
            </form>
        </section>

        <!-- STEP 3: YOU HAVE ORDERED... -->
        <section id="step3">
            <?php elseif ($currentStep === 3): ?>
            <form method="post" action="">
                <h2>STEP 3: YOU HAVE ORDERED...</h2>

                <?php
                // Fetch the accumulated data from the session for display
                $data = $_SESSION['reservation_data'] ?? [];
                ?>
                <p>
                    Below you find an overview of the books you have reserved. Once you confirm your reservation, you can pick them up at our KD and pay at the desk.
                </p>

                <!-- In a real application, the selected books would be dynamically displayed here. -->
                <ul>
                    <?php
                    if (isset($data['books']) && is_array($data['books'])) {
                        foreach ($data['books'] as $bookId) {
                            // Fetch the book title based on the book ID
                            $bookTitle = $shop->getBookTitle($bookId); // Assuming this method exists in your Shop class
                            echo "<li>" . htmlspecialchars($bookTitle) . "</li>";
                        }
                    } else {
                        echo "<li>No books selected</li>";
                    }
                    ?>
                </ul>

                <button id="step3_btn" type="submit">Confirm Reservation</button>
            </form>
        </section>
        <?php endif; ?>

    </main>
</div>

<!-- THIRD PART: footer -->
<div class="bottom-part">
    <footer>
        <p>©Copyright 2050 by nobody. All rights reversed.
            <a href="#">Privacy Policy</a>
            <a href="#">Term of Use</a>
        </p>
    </footer>
</div>
<script src="check-user.js"></script>
</body>
</html>