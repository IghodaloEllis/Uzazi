<?php
require 'config/database.php';

session_start();

// Create an instance of the Database class
$db = new Database();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user details
$user_id = $_SESSION['user_id'];
// Select all columns from both tables using aliases
$stmt = $db->prepare("SELECT u.*, ud.* FROM users u INNER JOIN user_details ud ON u.id = ud.user_id WHERE u.id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Retrieve the user's profile picture from the user_images table
$stmt = $db->prepare("SELECT image_path FROM user_images WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$profilePicture = $row['image_path'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - Uzazi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" class="card-img-top img-fluid mx-auto" width="auto" height="150">
                    <div class="card-body">
                        <h2><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h2>
                        <p>Email: <?php echo $user['email']; ?></p>
                        <p>Role: <?php echo $user['role']; ?></p>
                        <p>Status: <?php echo $user['status']; ?></p>
                        <p>Address: <?php echo $user['address']; ?></p>
                        <p>Nationality: <?php echo $user['nationality']; ?></p>
                        <p>Religion: <?php echo $user['religion']; ?></p>
                        <p>Phone Number: <?php echo $user['phone_number']; ?></p>
                        <p>Emergency Contact Name: <?php echo $user['emergency_contact_name']; ?></p>
                        <p>Emergency Contact Phone: <?php echo $user['emergency_contact_phone']; ?></p>
                        <p>Date of Birth: <?php echo $user['date_of_birth']; ?></p>
                        <p>Gender: <?php echo $user['gender']; ?></p>
                        <p>Bio: <?php echo $user['bio']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="upload_profile.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="profile_picture" class="form-control">
                            <button type="submit" class="btn btn-primary">Upload Profile Picture</button>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <div class="user-actions d-flex justify-content-between">
                            <a href="edit_profile.php" class="btn btn-secondary me-2">Edit Profile</a>
                            <a href="update_profile.php" class="btn btn-info">Update Profile</a>
                            <a href="logout.php" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>