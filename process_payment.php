<?php

// PHP composer is need to run this part.

/** We are testing with just paypal and Bank transfer but will definitely incorporate Credit cards and
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

// ... (other necessary includes)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $payment_method = $_POST['payment_method'];

    // Retrieve course information
    $stmt = $db->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();

    // Validate payment method
    if (!in_array($payment_method, ['paypal', 'bank_transfer'])) {
        // Handle invalid payment method
        header('Location: payments.php?error=invalid_payment_method');
        exit;
    }

    // Create payment request based on selected method
    if ($payment_method === 'paypal') {
        // Create PayPal payment request (adjust parameters as needed)
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item = new Item();
        $item->setName($course['course_name'])
             ->setCurrency('USD') // Adjust currency as needed
             ->setQuantity(1)
             ->setPrice($course['price']);

        // ... (rest of payment request creation)

        try {
            $payment->create($apiContext);
            header('location:' . $payment->getApprovalLink());
        } catch (Exception $ex) {
            // Handle payment creation errors
            header('Location: payments.php?error=paypal_error&message=' . urlencode($ex->getMessage()));
            exit;
        }
    } elseif ($payment_method === 'bank_transfer') {
    // Generate a unique transaction ID
    $transaction_id = uniqid();

    // Update course status to 'Pending Payment'
    $stmt = $db->prepare("UPDATE student_courses SET status = 'Pending Payment', transaction_id = ? WHERE course_id = ? AND student_id = ?");
    $stmt->bind_param("sii", $transaction_id, $course_id, $_SESSION['user_id']);
    $stmt->execute();

    // Display bank transfer instructions or details
    echo '<h2>Bank Transfer Instructions</h2>';
    echo '<p>Please transfer the payment of ' . $course['price'] . ' ' . $course['currency'] . ' to the following account:</p>';
    echo '<p><strong>Bank Name:</strong>Bank Name</p>';
    echo '<p><strong>Account Number:</strong>Bank Account Number</p>';
    echo '<p><strong>Reference Number:</strong> ' . $transaction_id . '</p>';
    echo '<p>Please use this reference number when making the transfer.</p>';
}