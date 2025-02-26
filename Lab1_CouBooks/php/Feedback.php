<?php

use php\Feedback_Class;

require_once 'Feedback_Class.php';

/*
If the submit button is pressed, create the Feedback instance
and save it to the database (all incl in the constructor)
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback = new Feedback_Class($_POST['author'], $_POST['feedback']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CouBooks</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="Feedback.css">
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
        <section>
            <form method="post" action="">
                <h2>ADD FEEDBACK</h2>

                <p>
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" required />
                </p>

                <p>
                    <label for="feedback">Feedback:</label>
                    <textarea id="feedback" name="feedback" rows="5" cols="33" required></textarea>
                </p>

                <div>
                    <input type="submit" value="Submit" name="submit" id="submit">
                </div>

            </form>
        </section>

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
<!-- Link to the external JavaScript file -->
<script src="feedback.js"></script>
</body>
</html>