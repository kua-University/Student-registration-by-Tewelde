<?php
use PHPUnit\Framework\TestCase;

class DatabaseIntegrityIntegrationTest extends TestCase
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

    public function testPaymentCompletionUpdatesRecords(): void
    {
        $registrationId = 1;

        $stmt = $this->conn->prepare("SELECT * FROM registrations WHERE id = :id AND payment_status = 'completed'");
        $stmt->execute(['id' => $registrationId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result, "Database integrity compromised after payment!");
    }
}
?>