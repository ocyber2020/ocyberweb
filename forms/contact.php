<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Load receiving email from config file (excluded from git)
  if( file_exists($config = __DIR__ . '/config.php') ) {
    include( $config );
  } else {
    die( 'Contact form is not configured. Please set up forms/config.php.' );
  }

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  // Sanitize inputs
  $name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
  $email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
  $subject = htmlspecialchars(strip_tags(trim($_POST['subject'] ?? '')));
  $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

  // Validate required fields
  if( empty($name) || empty($email) || empty($subject) || empty($message) ) {
    die('Please fill in all required fields.');
  }

  if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    die('Invalid email address.');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;

  $contact->to = $receiving_email_address;
  $contact->from_name = $name;
  $contact->from_email = $email;
  $contact->subject = $subject;

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  $contact->add_message( $name,    'From');
  $contact->add_message( $email,   'Email');
  $contact->add_message( $message, 'Message', 10);

  echo $contact->send();
?>
