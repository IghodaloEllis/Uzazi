<?php
require 'config/database.php';

session_start();


// Create an instance of the Database class
$db = new Database();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $file = $_FILES['profile_picture'];

    // Validate file upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $original_filename = basename($file['name']);
        $new_filename = uniqid() . '_' . $original_filename;
        $target_file = $target_dir . $new_filename;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow only certain image file types
        $allowed_types = array('jpg', 'jpeg', 'png');
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Insert the image path into the user_images table
                $stmt = $db->prepare("INSERT INTO user_images (user_id, image_path) VALUES (?, ?)");
                $stmt->bind_param("is", $user_id, $target_file);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    // Image uploaded successfully
                    header('Location: dashboard.php?success=profile_updated');
                    exit;
                } else {
                    // Error uploading image
                    header('Location: dashboard.php?error=image_upload_failed');
                    exit;
                }
            } else {
                // Error moving uploaded file
                header('Location: dashboard.php?error=file_upload_failed');
                exit;
            }
        } else {
            // Invalid file type
            header('Location: dashboard.php?error=invalid_file_type');
            exit;
        }
    } else {
        // File upload error
        header('Location: dashboard.php?error=file_upload_error');
        exit;
    }
}