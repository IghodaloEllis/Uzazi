<!DOCTYPE html>
<html style="background-color: #c0d2bb;">
<head>
  <title>New User Registration - Uzazi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <div class="login-container">
        <div class="site-image"></div>
        <form id="registerForm" action="process_register.php" method="post">
             <h2>New Student Registration - Uzazi</h2>
            <div class="logo"> </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="">Select a role</option>
                    <?php
                        $roles = ['instructor', 'student'];
                        foreach ($roles as $role) {
                            echo '<option value="' . $role . '">' . $role . '</option>';
                        }
                    ?>
                </select>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>

</body>
</html>

