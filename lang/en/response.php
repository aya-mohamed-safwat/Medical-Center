<?php
return [
    'success'  => 'Successful',
    'failed'   => 'Failed',
    'index'    => 'Data fetched successfully',
    'show'     => 'Data displayed successfully',
    'done'     => [
        'store'  => 'Data added successfully',
        'update' => 'Data updated successfully',
        'delete' => 'Data deleted successfully',
        'cancel' => 'session cancelled successfully'
    ],
    'error'    => [
        'store'  => 'Failed to store data',
        'update' => 'Failed to update data',
        'delete' => 'Failed to delete data',
        'permission' => 'You do not have permission to access this data',
    ],
    'auth'     => [
        'check_your_sms'       => 'Please check your SMS messages.',
        'invalid_email_or_otp' => 'Invalid email or OTP has expired.',
        'expired_otp'          => 'Incorrect code or OTP has expired.',
        'verified_and_create'  => 'Email successfully verified and new account created.',
        'wrong_number'         => 'The phone number is incorrect.',
        'wrong_pass'           => 'The password is incorrect.',
        'no_user'              => 'No account found for this user.',
        'change_pass'          => 'Password changed successfully.',
        'change_number'        => 'Phone number changed successfully.',
        'invalid_login'        => 'Invalid login. Please check your phone number and password.',
        'logout'               => 'Successfully logged out.',
    ],
    'favorite' => [
        'add'    => 'The doctor has been added to your favorites.',
        'exist'  => 'The doctor is already in your favorites.',
        'remove' => 'The doctor has been removed from your favorites.',
    ],
    'offer'    => [
        'not_added'       => 'You cannot book the offer twice at the same time.',
        'add'             => 'The offer has been added to your account.',
        'max_reservation' => 'You have reached the maximum number of reservations for this offer.',
    ],
    'payment'  => [
        'paid_offer'    => 'The operation cannot be completed. The offer is either already paid or not booked.',
        'sessionId'     => 'Session ID is required.',
        'offer_closed'  => 'This offer has already been paid or the time has expired.',
        'pay'           => 'Payment completed successfully.',
        'not_completed' => 'The payment process was not completed.',
    ],
];
