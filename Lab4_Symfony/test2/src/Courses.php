<?php

use php\Courses_Class;

require_once 'ConnectDb.php';
require_once 'Courses_Class.php';

// Create an instance of the Courses_Class
$coursesClass = new Courses_Class();

// Get all courses
$courses = $coursesClass->getAllCourses();

//// Return the courses as JSON
//echo json_encode($courses);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CouBooks</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="Courses.css">
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
                <article>
                    <p>
                        you can find an overview of all available courses.<br>
                        Click the listed book name for details.
                    </p>

                    <!-- Static ver: -->
                    <h2>Computer Networks</h2>
                    <ul>
                        <li data-isbn="9780133594140">Computer networking: a Top down approach.</li>
                    </ul>

                    <h2>Operating Systems</h2>
                    <ul>
                        <li data-isbn="0471694665">Course book: Operating system concepts</li>
                        <li>Lab: design an operation system for temperature sensor from scratch.</li>
                    </ul>


                    <!-- Dynamic ver: -->

                    <!-- An empty container where we’ll show the fetched book info. -->
                    <div id="result-container">
                        <div id="book-info">
                        </div>
                    </div>


                </article>
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
        <script src="../isbn.js"></script>
</body>
</html>