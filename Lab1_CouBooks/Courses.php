<?php
class Courses {
    // Database connection (assumed to be a PDO instance)
    protected $db;  // Supposed to be a PDO (property $conn in ConnectDb class).

    // Constructor accepts the PDO connection
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Retrieves all courses from the "course" table.
     *
     * @return array Returns an array of course objects.
     */
    public function getAllCourses(): array {
        $sql = "SELECT * FROM course";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Retrieves books for a given course ID.
     *
     * @param int $courseId The course id for which to retrieve books.
     * @return array Returns an array of book objects.
     */
    public function getBooksByCourseId($courseId): array {
        // Assuming there is a "book" table with a "course_id" foreign key.
        $sql = "SELECT * FROM book WHERE course = :course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

// Usage example:
// Assume $pdo is a valid PDO instance connected to the database.
// $courses = new Courses($pdo);
// $allCourses = $courses->getAllCourses();
// $booksForCourse = $courses->getBooksByCourseId($someCourse->getId());
?>
