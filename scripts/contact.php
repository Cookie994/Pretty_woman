<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';
    
        $errors = "";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim(filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING));
            $ename = trim(filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL));
            $email = filter_var($ename, FILTER_VALIDATE_EMAIL);
            $subject = trim(filter_var($_REQUEST['subject'], FILTER_SANITIZE_STRING));
            $message = trim(filter_var($_REQUEST['message'], FILTER_SANITIZE_STRING));
            
            if(empty($name) && empty($email)) {
                $errors = "You must enter your name and email address";
            }
            
            if($errors == ""){
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP(); 
                    $mail->Host = 'smtp.host.net';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'username';
                    $mail->Password = 'password';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    //Recipients
                    $mail->setFrom('sender@mail.com');
                    $mail->addAddress('recipient@mail.com');

                    //Content
                    $mail->isHTML(false);          
                    $mail->Subject = "Website Kontakt Forma od: $name";
                    $mail->Body    = "Dobili ste poruku putem kontakt forme sa prettywoman.rs website-a.\n\n"."Evo detalja:\n\nIme: $name\n\nEmail: $email\n\nNaslov: $subject\n\nPoruka: $message";

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: ../thank_you.php");
                    } catch (Exception $e) {
                        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }

            } else {
                echo $errors;
                
            }
            
        }
        
    ?>
