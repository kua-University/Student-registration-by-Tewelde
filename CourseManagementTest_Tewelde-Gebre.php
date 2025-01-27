<?php
use PHPUnit\Framework\TestCase;

class CourseManagementTest extends TestCase
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

    public function testAddCourse(): void
    {
        $courseName = 'Machine Learning';
        $courseFee = 99.99;

        $stmt = $this->conn->prepare("INSERT INTO courses (course_name, course_fee) VALUES (:course_name, :course_fee)");
        $stmt->execute(['course_name' => $courseName, 'course_fee' => $courseFee]);

        $this->assertTrue($stmt->rowCount() > 0, "Course should be added successfully.");
    }

    public function testUpdateCourse(): void
    {
        $courseId = 1; // Assuming course with ID 1 exists
        $newFee = 120.50;

        $stmt = $this->conn->prepare("UPDATE courses SET course_fee = :course_fee WHERE id = :id");
        $stmt->execute(['course_fee' => $newFee, 'id' => $courseId]);

        $this->assertTrue($stmt->rowCount() > 0, "Course fee should be updated successfully.");
    }

    public function testDeleteCourse(): void
    {
        $courseId = 2; // Assuming course with ID 2 exists

        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id = :id");
        $stmt->execute(['id' => $courseId]);

        $this->assertTrue($stmt->rowCount() > 0, "Course should be deleted successfully.");
    }
}
?>