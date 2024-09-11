<?php

// PHP composer is need to run this part.

/** We are testing with just paypal and Bank transfer but will definitely include Credit cards and
  and many other payment options **/

require 'config/database.php';
require 'vendor/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payer;

session_start();

// ...

// Create PayPal API context
$apiContext = new \PayPal\Rest\ApiContext(
    new OAuthTokenCredential(
        'client_id', // Replace with your client ID
        'client_secret' // Replace with your client secret
    )
);

// Retrieve enrolled courses and pricing information
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT c.*, cp.price, cp.currency FROM student_courses sc INNER JOIN courses c ON sc.course_id = c.course_id INNER JOIN course_pricing cp ON c.course_id = cp.course_id WHERE sc.student_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payments - Uzazi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="container py-4">
        <h1>Payments</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Price</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo $course['course_name']; ?></td>
                        <td><?php echo $course['price']; ?></td>
                        <td><?php echo $course['currency']; ?></td>
                        <td><?php echo $course['status']; ?></td>
                        <td>
                            <?php if ($course['status'] === 'Enrolled' && !isset($course['payment_id'])): ?>
                                <form action="process_payment.php" method="post">
                                    <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method:</label>
                                        <select name="payment_method" class="form-control" id="payment_method" onchange="showBankDetails()">
                                            <option value="paypal">PayPal</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="make-payment-btn">Make Payment</button>
                                </form>
                                <div id="bank-details" class="mt-3" style="display: none;">
                                    </div>
                            <?php elseif ($course['status'] === 'Completed'): ?>
                                <button class="btn btn-success disabled">Payment Completed</button>
                            <?php else: ?>
                                <button class="btn btn-secondary disabled">Pending</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        function showBankDetails() {
            var paymentMethod = document.getElementById('payment_method').value;
            if (paymentMethod === 'bank_transfer') {
                // Make AJAX request to get bank details
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_bank_details.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            alert(response.error);
                        } else {
                            // Display bank details in the popup
                            var bankDetailsDiv = document.getElementById('bank-details');
                            bankDetailsDiv.innerHTML = `
                                <p><strong>Bank Name:</strong> ${response.bank_name}</p>
                                <p><strong>Account Number:</strong> ${response.account_number}</p>
                                <p><strong>SWIFT Code:</strong> ${response.swift_code}</p>
                            `;
                            bankDetailsDiv.style.display = 'block';
                        }
                    } else {
                        alert('Error fetching bank details.');
                    }
                };
                xhr.send('payment_method=' + paymentMethod);
            } else {
                // Hide bank details if payment method is not bank transfer
                var bankDetailsDiv = document.getElementById('bank-details');
                bankDetailsDiv.style.display = 'none';
            }
        }
    </script>

    </body>
</html>