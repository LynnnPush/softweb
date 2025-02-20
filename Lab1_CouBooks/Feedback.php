<?php

class Feedback
{
    // Due to the save() method in the constructor, the object always refers to the last feedback.
    private string $author;
    private string $text;
    private string $created;
    private int $id;
    // Instance of ConnectDb
    private $db;
    private  $conn;


    public function __construct(string $author, string $text)
    {
        // First establish connection with the database
        $this->db = ConnectDb::getInstance();
        $this->conn = $this->db->getConnection();

        // Set the properties
        $this->author = $author;
        $this->text = $text;
        $this->created = date('Y-m-d H:i:s');
    }

    public function save(): void
    {
        $stm = $this->conn->prepare('INSERT INTO feedback (author, text, created) VALUES (:author, :text, :created);');
        $stm->execute([':author' => $this->author, ':text' => $this->text, ':created'=> $this->created]);
        $this->id = $this->conn->lastInsertId();    // Note that the object always refers to the last feedback.
    }

    public function getAllFeedback(): array
    {
        $stm = $this->conn->prepare('SELECT * FROM feedback');
        $stm->execute();
        $result = array();
        while ($item = $stm->fetch()) {
            $feedback = new Feedback($item['author'], $item['text']);
            $feedback->setId($item['id']);
            $feedback->setCreated($item['created']);
            $result[] = $feedback;
        };
        return $result;
    }



    public function getAuthor(): string
    {
        if (!empty($this->author)) {
            return $this->author;
        }

        try {
            $stm = $this->conn->prepare('SELECT author FROM feedback WHERE id = :id');
            $stm->execute([':id' => $this->id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['author'])) {
                $this->author = $result['author'];
                return $this->author;
            }
        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Error fetching author: " . $e->getMessage());
        }

        return '';
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setCreated(string $created): void
    {
        $this->created = $created;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

}