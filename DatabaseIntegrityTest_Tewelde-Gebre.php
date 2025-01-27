<?php
use PHPUnit\Framework\TestCase;

class DatabaseIntegrityTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $host = 'localhost';
        $db = 'registration_system';
        $user = 'root';
        $pass = '';
        $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    }

    public function testDeleteStudentWithRegistrations(): void
    {
        $studentId = 1; // Assuming student ID 1 has registrations

        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = :id");
        $this->expectException(PDOException::class); // Deletion should fail due to foreign key
        $stmt->execute(['id' => $studentId]);
    }
}
?>