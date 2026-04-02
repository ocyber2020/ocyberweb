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
    die( 'Newsletter form is not configured. Please set up forms/config.php.' );
  }

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  // Sanitize and validate email
  $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

  if( empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    die('Please enter a valid email address.');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;

  $contact->to = $receiving_email_address;
  $contact->from_name = $email;
  $contact->from_email = $email;
  $contact->subject = 'New Newsletter Subscription: ' . $email;

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  $contact->add_message( $email, 'Email');

  echo $contact->send();
?>
