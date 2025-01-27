<?php
use PHPUnit\Framework\TestCase;

class LoginAuthenticationTest extends TestCase
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

    public function testValidLogin(): void
    {
        // Insert a test user
        $this->conn->query("DELETE FROM admins WHERE username = 'admin'");
        $this->conn->query("INSERT INTO admins (username, password) VALUES ('admin', MD5('password123'))");

        // Simulate login
        $username = 'admin';
        $password = md5('password123'); // MD5 used for hashing example

        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE username = :username AND password = :password");
        $stmt->execute(['username' => $username, 'password' => $password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result, "Login should succeed for valid credentials.");
    }

    public function testInvalidLogin(): void
    {
        $username = 'admin';
        $password = md5('wrongpassword'); // Wrong password

        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE username = :username AND password = :password");
        $stmt->execute(['username' => $username, 'password' => $password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEmpty($result, "Login should fail for invalid credentials.");
    }
}
?>