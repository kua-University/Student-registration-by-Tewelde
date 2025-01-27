<?php
use PHPUnit\Framework\TestCase;

class RegistrationIDValidationTest extends TestCase
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

    public function testValidRegistrationID(): void
    {
        $registrationId = 1; // Assuming this ID exists

        $stmt = $this->conn->prepare("SELECT * FROM registrations WHERE id = :id");
        $stmt->execute(['id' => $registrationId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result, "Valid registration ID should return a record.");
    }

    public function testInvalidRegistrationID(): void
    {
        $registrationId = 9999; // Non-existent ID

        $stmt = $this->conn->prepare("SELECT * FROM registrations WHERE id = :id");
        $stmt->execute(['id' => $registrationId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEmpty($result, "Invalid registration ID should return no record.");
    }
}
?>