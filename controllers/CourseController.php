<?php
session_start();

require_once 'classes/Course.php';
require_once 'classes/Database.php';

class CourseController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAllCourses() {
        if (isAdmin()) {
            // Fetch all courses for admin
            $sql = "SELECT * FROM courses";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Fetch courses for the logged-in user
            $userId = $_SESSION['user_id'];
            // Assuming a 'student_courses' table for linking users to courses
            $sql = "SELECT c.* FROM courses c
                    INNER JOIN student_courses sc ON c.id = sc.course_id
                    WHERE sc.student_id = :userId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }


    public function getCourseById($courseId) {
        // Logic to retrieve a specific course
    }

    public function createCourse($data) {
        // Logic to create a new course
    }

    public function updateCourse($courseId, $data) {
        // Logic to update a course
    }

    public function deleteCourse($courseId) {
        // Logic to delete a course
    }
}
