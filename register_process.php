<?php
include("connect.php");

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Your secret reCAPTCHA key
    $secretKey = '6LeAVKIpAAAAAGVh8NSivJJt7kG0jxOdJvorDZXG';

    // Get the reCAPTCHA response from the form
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verify the reCAPTCHA response
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = array(
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    );

    $recaptchaOptions = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        )
    );

    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaJson = json_decode($recaptchaResult);

    // Check if reCAPTCHA verification succeeded
    if ($recaptchaJson->success) {
        // reCAPTCHA verification successful, proceed with form processing

        // Rest of your form processing code goes here...
    } else {
        // reCAPTCHA verification failed
        echo "reCAPTCHA verification failed. Please make sure you're not a robot.";
        // You might want to handle this case by showing an error message to the user or redirecting them back to the registration page.
    }
}
