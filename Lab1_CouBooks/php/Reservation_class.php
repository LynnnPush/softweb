<?php

namespace php;

use PDO;
use PDOException;

class Reservation_class
{
    private $email;
    private $books;
    // Database connection (assumed to be a PDO instance)
    protected $db;  // Supposed to be a PDO (property $conn in ConnectDb class).

    // Constructor accepts the PDO connection
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // --- Setters ---
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setBook(array $selected_books): void
    {
        $this->books = $selected_books;
    }

    // --- Save to database ---
    public function save(): int
    {
        try {
            // Start a transaction to ensure all queries succeed or fail together.
            $this->db->beginTransaction();

            // Step 1: Lookup the student by email.
            $stmt = $this->db->prepare("SELECT id FROM student WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $this->email]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($student && isset($student['id'])) {
                // Found an existing student.
                $studentId = $student['id'];
            } else {
                // No student found: insert a new record.
                // Assuming the student table has at least the columns 'name' and 'email'.
                $stmt = $this->db->prepare("INSERT INTO student (email) VALUES (:email)");
                $stmt->execute([
                    ':email' => $this->email
                ]);
                $studentId = $this->db->lastInsertId();
            }

            // Step 2: Insert the reservation.
            // The 'created' column will be automatically set by the default CURRENT_TIMESTAMP.
            $stmt = $this->db->prepare("INSERT INTO reservation (student) VALUES (:student)");
            $stmt->execute([':student' => $studentId]);
            $reservationId = $this->db->lastInsertId();

            // Step 3: Insert into reservation_book for each book in $this->books.
            // Assuming $this->books is an array of book IDs.
            if (!empty($this->books) && is_array($this->books)) {
                $stmt = $this->db->prepare("INSERT INTO reservation_book (reservation, book) VALUES (:reservation, :book)");
                foreach ($this->books as $bookId) {
                    $stmt->execute([
                        ':reservation' => $reservationId,
                        ':book' => $bookId
                    ]);
                }
            }

            // Commit the transaction if all queries were successful.
            $this->db->commit();

            // Optionally return the new reservation id.
            return $reservationId;
        } catch (PDOException $e) {
            // Rollback the transaction on error.
            $this->db->rollBack();
            echo "Database error: " . $e->getMessage();
            return 0; // or rethrow the exception as needed
        }
    }
}