<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';
    
        
        $name = $email = $subject = $message = "";
        $nameErr = $emailErr = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $nameErr = "Enter name";
            } else {
                $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed"; 
            } 
            }
            if (empty($_POST["email"])) {
                $emailErr = "Enter email";
            } else {
                $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format"; 
            }
            }
            $subject = test_input($_POST["subject"]);
            $message = test_input($_POST["message"]);
            header("Location: ../thank_you.php");
        }
            function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP(); 
            $mail->Host = 'mmail.domain.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'username@domain.com';
            $mail->Password = 'password';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            //Recipients
            $mail->setFrom('test@test.com', 'no-reply');
            $mail->addAddress('test@test.com');

            //Content
            $mail->isHTML(false);          
            $mail->Subject = "Website Kontakt Forma od: $name";
            $mail->Body    = "Dobili ste poruku putem kontakt forme sa prettywoman.rs website-a.\n\n"."Evo detalja:\n\nIme: $name\n\nEmail: $email\n\nNaslov: $subject\n\nPoruka: $message";

            $mail->send();
            echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    ?>
