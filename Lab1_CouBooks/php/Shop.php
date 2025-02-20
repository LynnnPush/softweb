<?php

namespace php;
use PDO;
use php\Reservation_class;

require_once 'Reservation_class.php';

class Shop
{
    private $step;
    private $data;
    private $db;

    /**
     * Constructor
     * - Starts session (if not already started)
     * - Loads current step from session or defaults to 1
     * - Loads reservation data array from session or defaults to empty
     */
    public function __construct($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load step from session (default to 1 if not set)
        $this->step = $_SESSION['current_step'] ?? 1;

        // Load reservation data array from session (default to empty array)
        $this->data = $_SESSION['reservation_data'] ?? [];

        // Pass the database connection PDO variable
        $this->db = $db;
    }

    /**
     * processStep
     * - Merges the posted data into $this->data
     * - Updates session
     * - Increments step counter
     */
    public function processStep(array $postData)
    {
        // Merge the newly posted data into our existing data
        $this->data = array_merge($this->data, $postData);
        $_SESSION['reservation_data'] = $this->data;

        // Move to the next step
        $this->step++;
        $_SESSION['current_step'] = $this->step;
    }

    /**
     * storeOrder
     * - Called on the final step to persist data to the database
     */
    public function storeOrder()
    {
        // Create a ReservationClass object and populate it
        $reservation = new Reservation_class($this->db);
        $reservation->setEmail($this->data['email'] ?? '');
        $reservation->setBook($this->data['books'] ?? '');

        // Save the reservation to the database
        $reservation->save();

        // Optionally clear session data or reset steps
        // session_unset();
        // session_destroy();
    }

    /**
     * getStep
     * - Returns the current step
     */
    public function getStep(): int
    {
        return $this->step;
    }

    // Fetch the book title based on the book ID
    public function getBookTitle($bookId)
    {
        $stmt = $this->db->prepare("SELECT title FROM book WHERE id = :bookId");
        $stmt->execute([':bookId' => $bookId]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        return $book ? $book['title'] : 'Unknown Book';
    }
}
