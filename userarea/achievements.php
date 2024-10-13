<?php

// using the database connection configured
require 'config/database.php';

//Start the session
session_start();

// Get user achievements
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM student_achievements WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

//loop each row in the query
$achievements = [];
while ($row = mysqli_fetch_assoc($result)) {
    $achievements[] = $row;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
// ... (fetch achievements logic)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Achievements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>My Achievements</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Achievement Name</th>
                    <th>Achievement Type</th>
                    <th>Description</th>
                    <th>Date Achieved</th>
                    <th>Proof Link</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($achievements as $achievement): ?>
                    <tr>
                        <td><?php echo $achievement['achievement_name']; ?></td>
                        <td><?php echo $achievement['achievement_type']; ?></td>
                        <td><?php echo $achievement['description']; ?></td>
                        <td><?php echo $achievement['date_achieved']; ?></td>
                        <td><a href="<?php echo $achievement['proof_link']; ?>">View Proof</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>