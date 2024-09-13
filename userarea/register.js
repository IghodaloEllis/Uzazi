$(document).ready(function() {
    $('#registerForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'register_step1.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Proceed to step 2
                    $('#registerForm').html(response.html);
                } else {
                    // Handle registration errors
                    alert(response.message);
                }
            }
        });
    });
});