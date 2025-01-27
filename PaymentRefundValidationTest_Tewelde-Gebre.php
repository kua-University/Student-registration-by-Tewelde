<?php
use PHPUnit\Framework\TestCase;

class PaymentRefundValidationTest extends TestCase
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

    public function testRefund(): void
    {
        $registrationId = 1; // Assuming registration ID exists

        // Update payment status to "refunded"
        $stmt = $this->conn->prepare("UPDATE registrations SET payment_status = 'refunded' WHERE id = :id");
        $stmt->execute(['id' => $registrationId]);

        // Verify status
        $stmt = $this->conn->prepare("SELECT payment_status FROM registrations WHERE id = :id");
        $stmt->execute(['id' => $registrationId]);
        $status = $stmt->fetchColumn();

        $this->assertEquals('refunded', $status, "Payment status should be 'refunded'.");
    }
}
?>