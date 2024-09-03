<!DOCTYPE html>
<html>
<head>
    <title>UZAZI - DASHBOARD </title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>User home</h1>

    <?php
    // Include necessary files
    require_once 'controllers/UserController.php';
    require_once 'controllers/CourseController.php';

    // Instantiate controllers
    $userController = new UserController();
    $courseController = new CourseController();

    // Example: Fetch and display data
    $users = $userController->getAllUsers();
    $courses = $courseController->getAllCourses();

    // Display user data or course data
    // ...
    ?>

    <script src="js/script.js"></script>
</body>
</html>
