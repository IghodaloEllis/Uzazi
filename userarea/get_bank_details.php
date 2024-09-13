<?php
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];

    // Retrieve bank details based on payment method
    if ($payment_method === 'bank_transfer') {
        $bank_details = [
            'bank_name' => 'Bank Name',
            'account_number' => 'Bank Account Number',
            'swift_code' => 'SWIFT Code',
            // other relevant bank details
        ];

        // Return bank details as JSON
        header('Content-Type: application/json');
        echo json_encode($bank_details);
    } else {
        // Handle invalid payment method
        echo json_encode(['error' => 'Invalid payment method']);
    }
}