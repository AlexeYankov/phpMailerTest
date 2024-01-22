<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$routes = [
    '/server.php' => 'sendTo',
];

// Handle the API request
$request = $_SERVER['REQUEST_URI'];

if (array_key_exists($request, $routes)) {
    $action = $routes[$request];
    if (function_exists($action)) {
        $result = call_user_func($action);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'Invalid route']);
}


// API action: Send message
function sendTo()
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
    
        $mail->addAddress('rbru-metrika@yandex.ru');
    
        $mail->isHTML(true);

        $bodySubject = $_POST["message"] . ' ' . $_POST["email"] . ' ' . $_POST["name"];
    
        $mail->Subject = $_POST["tel"];
        $mail->Body = $bodySubject;
    
        $mail->send();

        
        echo
        "
        <script>
        alert('Форма отправлена. Мы свяжемся с Вами в ближайшее время');
        window.location.replace('https://rocket-business-gamma.vercel.app/');
        </script>
        ";

        
        return ['tel' => $tel, 'name' => $name, 'email' => $email, 'message' => $message];
    } else {
        return ['error' => 'Email not provided in the POST request'];
    }
}
