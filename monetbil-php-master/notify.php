<?php

require_once 'monetbil.php';

// Simulate a payment success
$payment_status = Monetbil::STATUS_SUCCESS;

// Handle the simulated payment status
if (Monetbil::STATUS_SUCCESS == $payment_status) {
    // Successful payment!
    // Mark the order as paid in your system
} elseif (Monetbil::STATUS_CANCELLED == $payment_status) {
    // Transaction cancelled
} else {
    // Payment failed!
}

// Simulate receipt of notification
exit('received');
