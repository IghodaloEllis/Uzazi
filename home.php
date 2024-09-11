

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - Uzazi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="d-flex justify-content-between align-items-center py-3 bg-light">
        <div class="text-light fw-bold fs-4">Uzazi - School Dashboard</div>
        <div class="user-actions d-flex align-items-center">
            <span class="me-3">Hello, <?php echo $user['first_name']; ?></span>
            <a href="update_profile.php" class="btn btn-info me-2">Update Profile</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </header>

    <main class="container py-4">
        <div class="row">
            <nav class="col-md-3 col-sm-4 mb-3 d-none d-md-block">
                <ul class="nav flex-column nav-pills bg-light rounded-3 shadow-sm">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">Learning</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Achievements</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Payments</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Transactions</a>
                    </li>
                </ul>
            </nav>

            <div class="col-md-9 col-sm-8">
                <?php include 'dashboard.php'; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>