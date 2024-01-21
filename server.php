<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Set the response header to JSON
header("Content-Type: application/json");

// Define the API routes and corresponding actions
$routes = [
    '/server.php' => 'hello',
    '/api/add' => 'addNumbers',
];

$postData = file_get_contents("php://input");
$decodedData = json_decode($postData, true);

// Handle the API request
$request = $_SERVER['REQUEST_URI'];

if (array_key_exists($request, $routes)) {
    $action = $routes[$request];
    if (function_exists($action)) {
        $result = call_user_func($action);
        $value = $decodedData['email'];
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'Invalid route']);
}

// API action: Say hello
function hello()
{
    if (isset($_POST['email'], $_POST['message'], $_POST['tel'])) {
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $message = $_POST['message'];
        $email = $_POST['email'];

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rocket.business.test.61@gmail.com';
        $mail->Password = 'agjwwhusutfxtclv';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    
        $mail->setFrom($_POST["email"]);
    
        $mail->addAddress('rocket.business.test.61@gmail.com');
    
        $mail->isHTML(true);
    
        $mail->Subject = $_POST["tel"];
        $mail->Body = $_POST["name"];
        $mail->Body = $_POST["email"];
        $mail->Body = $_POST["message"];
    
        $mail->send();
    
        return ['tel' => $tel, 'name' => $name, 'email' => $email, 'message' => $message];
    } else {
        return ['error' => 'Email not provided in the POST request'];
    }
}
