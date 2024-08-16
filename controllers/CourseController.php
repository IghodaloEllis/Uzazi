<?php
require_once 'classes/Course.php';
require_once 'classes/Database.php';

class CourseController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllCourses() {
        // Logic to retrieve all courses
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
