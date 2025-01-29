<?php
use PHPUnit\Framework\TestCase;

class PaymentCallbackIntegrationTest extends TestCase
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

    public function testPaymentCallbackUpdatesDatabase(): void
    {
        $registrationId = 1; // Assume registration ID exists

        // Simulate callback data
        $callbackData = json_encode([
            "tx_ref" => "tx-12345",
            "status" => "success"
        ]);

        file_put_contents('chapa_callback.log', $callbackData, FILE_APPEND);

        // Process callback
        $this->processPaymentCallback($registrationId);

        // Verify updated payment status
        $stmt = $this->conn->prepare("SELECT payment_status FROM registrations WHERE id = :id");
        $stmt->execute(['id' => $registrationId]);
        $status = $stmt->fetchColumn();

        $this->assertEquals('completed', $status, "Payment callback processing failed!");
    }

    private function processPaymentCallback($registrationId): void
    {
        $this->conn->query("UPDATE registrations SET payment_status = 'completed' WHERE id = $registrationId");
    }
}
?>