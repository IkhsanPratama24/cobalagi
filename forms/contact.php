<?php
/**
 * Requires the "PHP Email Form" library
 * The "PHP Email Form" library is available only in the pro version of the template
 * The library should be uploaded to: vendor/php-email-form/php-email-form.php
 * For more info and help: https://bootstrapmade.com/php-email-form/
 */

// Replace with your real receiving email address
$receiving_email_address = 'comsmakda@gmail.com';

// Include the PHP Email Form library
$php_email_form_path = '../assets/vendor/php-email-form/php-email-form.php';
if (file_exists($php_email_form_path)) {
    include($php_email_form_path);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

// Create a new instance of the PHP Email Form
$contact = new PHP_Email_Form();
$contact->ajax = true;

// Set up the email parameters
$contact->to = $receiving_email_address;

// Validate and sanitize inputs
$contact->from_name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : 'No Name';
$contact->from_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? htmlspecialchars(trim($_POST['email'])) : 'no-reply@example.com';
$contact->subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : 'No Subject';

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
/*
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

// Add messages to be sent in the email
if (isset($_POST['message'])) {
    $contact->add_message(htmlspecialchars(trim($_POST['name'])), 'From');
    $contact->add_message(htmlspecialchars(trim($_POST['email'])), 'Email');
    $contact->add_message(htmlspecialchars(trim($_POST['message'])), 'Message',); // Assuming 'message' is the name of the input for the message
} else {
    die('Message is required.');
}

// Send the email and echo the result
echo $contact->send();
?>