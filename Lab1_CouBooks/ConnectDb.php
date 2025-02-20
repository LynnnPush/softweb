<?php

class ConnectDb
{
// Hold the class instance.
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'MYSQLlyn123!';
    private $name = 'coubooks'; // Same as 'schema' in the MySQL workbench content

    // The db connection is established in the private constructor.
    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->name}", $this->user, $this->pass);

            // Set PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Set character set to UTF-8
            $this->conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

            // Use prepared statements for security
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Optional: For better performance in most cases
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // Log the error and throw a custom exception
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new ConnectDb();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}