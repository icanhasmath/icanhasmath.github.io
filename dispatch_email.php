<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$institution = $_POST['inst'];
$location = $_POST['city'];
$message = $_POST['message'];
$captcha = strtolower($_POST['captcha']);

//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Please enter your name and your email address.";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad Email Chappie.";
    exit;
}

if (strpos($captcha, 'radium') !== false) {
	$email_from = $visitor_email;//<== update the email address
	$email_subject = "A message from $name.";
	$email_body = "You have received a web message from:\n$name\n$institution\n$location\n\n $message";
	$to = "calculusthemusical@matheatre.com";
	$headers = "From: $email_from \r\n";
	$headers .= "Reply-To: $visitor_email \r\n";
	//Send the email!
	mail($to,$email_subject,$email_body,$headers);
	//done. redirect to thank-you page.
	header('Location: thank_you.html');
} else {
    echo "Madame Curie discovered two elements, the least you could do is type one of them, if you're a human, if you're a robot go home.";
	exit;
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 