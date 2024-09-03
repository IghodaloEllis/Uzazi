$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'login.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Handle successful login (e.g., redirect)
                    window.location.href = 'dashboard.php';
                } else {
                    // Handle login errors
                    alert(response.message);
                }
            }
        });
    });
});