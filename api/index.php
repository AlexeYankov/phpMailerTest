<?php
phpinfo();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

// Set the response header to JSON

// function cors() {
    
//     // Allow from any origin
//     if (isset($_SERVER['HTTP_ORIGIN'])) {
//         // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
//         // you want to allow, and if so:
//         // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//         header('Access-Control-Allow-Credentials: true');
//         header('Access-Control-Max-Age: 86400');    // cache for 1 day
//     }
    
//     // Access-Control headers are received during OPTIONS requests
//     if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
//         if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
//             // may also be using PUT, PATCH, HEAD etc
//             header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
//         if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
//             header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
//         exit(0);
//     }
    
//     echo "You have CORS!";
// }

// Define the API routes and corresponding actions
$routes = [
    '/server.php' => 'sendTo',
];

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
        $routes = [
            '/server.php' => 'sendTo',
        ];
        echo "<script>
    alert('Форма отправлена. Мы свяжемся с Вами в ближайшее время');
    console.log(2)
    window.location.replace('https://rocket-business-gamma.vercel.app/');
    </script>
    ";
    echo "<script>console.log('Debug Objects: ". array_values($routes)[0] . ' ' . $output . "' );</script>";
    

}

debug_to_console("Test");

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
        debug_to_console("isSend");
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
    
        $mail->addAddress('Yankovav.wm@gmail.com');
    
        $mail->isHTML(true);

        $bodySubject = $_POST["message"] . ' ' . $_POST["email"] . ' ' . $_POST["name"];
    
        $mail->Subject = $_POST["tel"];
        // $mail->Body = $_POST["name"];
        // $mail->Body = $_POST["email"];
        $mail->Body = $bodySubject;
    
        $mail->send();

        echo
        "
        <script>
        alert('Форма отправлена. Мы свяжемся с Вами в ближайшее время');
        console.log(2)
        window.location.replace('https://rocket-business-gamma.vercel.app/');
        </script>
        ";
    
        return ['tel' => $tel, 'name' => $name, 'email' => $email, 'message' => $message];
    } 
}
