<?php


session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

header('Content-Type: application/json');

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'])) {
        if ($data['action'] === 'signup') {
            $username = $data['username'];
            $email = $data['email'];
            $phone = $data['phone'];
            $password = $data['password'];

            if (!preg_match('/^[a-zA-Z]{3,}$/', $username)) {
                $response['status'] = 'error';
                $response['message'] = 'Username must be at least 3 characters long and contain only alphabets.';
                echo json_encode($response);
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['status'] = 'error';
                $response['message'] = 'Invalid email format.';
                echo json_encode($response);
                exit();
            }

            if (!preg_match('/^7[0-9]{8}$/', $phone)) {
                $response['status'] = 'error';
                $response['message'] = 'phone number must start with 7 and be 9 digits long.';
                echo json_encode($response);
                exit();
            }

            if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
                $response['status'] = 'error';
                $response['message'] = 'Password must be at least 8 characters long and contain at least one letter and one number.';
                echo json_encode($response);
                exit();
            }
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? OR phone = ?');
            $stmt->execute([$email, $phone]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $response['status'] = 'error';
                $response['message'] = 'Email or phone number already exists';
            }else{

            $token = bin2hex(random_bytes(32));

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare('INSERT INTO users (username, email, phone, password,token) VALUES (?, ?, ?, ?, ?)');
            try {
                $stmt->execute([$username, $email, $phone, $passwordHash,$token ]);
                try {
                    $mail->SMTPDebug = 2;									 
                    $mail->isSMTP();										 
                    $mail->Host	 = 'smtp.gmail.com;';				 
                    $mail->SMTPAuth = true;							 
                    $mail->Username = 'shathaalbajly@gmail.com';				 
                    $mail->Password = 'etnj qetu zccs oecf';					 
                    $mail->SMTPSecure = 'tls';							 
                    $mail->Port	 = 587; 
                
                    $mail->setFrom('shathaalbajly@gmail.com', 'chrrisr');		 
                    $mail->addAddress($email, 'shatha');
                    
                    $mail->isHTML(true);								 
                    $mail->Subject = 'Subject';
                    $mail->Body = "http://localhost/confirm-your-email.php?token=$token";
                    $mail->AltBody =  $token;
                    $mail->send();
                    echo "email sent successfully";
                } catch (Exception $e) {
                    $response['status'] = 'error';
                    $response['message'] = 'can not send email';
                }

                
                $response['status'] = 'success';
                $response['message'] = 'Sign up successful';
            } catch (\PDOException $e) {
                if ($e->getCode() == 23000) {
                    $response['status'] = 'error';
                    $response['message'] = 'mail or phone number already exists';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'error occurred: ' . $e->getMessage();
                }
            }}
        } elseif ($data['action'] === 'login') {
            $email = $data['email'];
            $password = $data['password'];

            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $response['status'] = 'success';
                $response['message'] = 'log in successful';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'wrong  email or password';
            }
        }
        elseif ($data['action'] === 'resetPassword') {
            $email = $data['email'];

            $token = bin2hex(random_bytes(32));
            $response['status'] = 'sucess';
            $response['message'] = $email;


            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? OR phone = ?');
            $stmt->execute([$email, $phone]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                
            $stmt = $pdo->prepare('UPDATE users SET token = ? WHERE email = ?');
            $stmt->execute([$token, $email]);
           
            
            try {
                $mail->SMTPDebug = 2;									 
                $mail->isSMTP();										 
                $mail->Host	 = 'smtp.gmail.com;';				 
                $mail->SMTPAuth = true;							 
                $mail->Username = 'shathaalbajly@gmail.com';				 
                $mail->Password = 'etnj qetu zccs oecf';					 
                $mail->SMTPSecure = 'tls';							 
                $mail->Port	 = 587; 
            
                $mail->setFrom('shathaalbajly@gmail.com', 'chrrisr');		 
                $mail->addAddress($email, 'shatha');
                
                $mail->isHTML(true);								 
                $mail->Subject = 'reset password';
                $mail->Body = "http://localhost/reset-password.php?token=$token";
                $mail->send();
                echo "the email sent successfully";
            } catch (Exception $e) {
                $response['status'] = 'error';
                $response['message'] = 'can not send email';
            }
            

                
            }else{
                $response['status'] = 'error';
                $response['message'] = 'this email or phone does not exist please create new ccount';
            }

     
        }
        elseif ($data['action'] === 'changePassword') {
            $password = $data['password'];
            $user_id =$_SESSION['user_id'];

            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                if ($user ) {
                    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                    $stmt->execute([$password, $user_id]);
                    $response['status'] = 'success';
                    $response['message'] = 'password changed successfully';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'please login';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'wrong  password';
            }
           
        }
    }
}


echo json_encode($response);
exit();
?>



