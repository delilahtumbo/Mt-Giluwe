<?php
    //lets get all form values

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $message = $_POST['message'];

    if(!empty($email) && !empty($message))
    { //if email and message field is not empty
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        { //if user entered email is valid
            $receiver = "00022@student.wpu.ac.pg"; //recievers email address
            $subject = "From: $name <$email>"; //subject of the email. Subject looks like From: 
            
            //merging connecting all user values inside body variable. \n is used for new line
            $body = "Name: $name\nEmail: $email\nPhone: $phone\nCountry: $country\n\nMessage: $message\n\nRegards, \n$name";
            $sender = "From: $email"; //sender email
            if(mail($receiver, $subject, $body, $sender))
                { //mail() is an inbuilt php function to send mail
                    echo "Your mesage has been sent!";
                }
            else
                {
                    echo "Sorry, faild to send your message!";

                }
        }

        else
            {
                echo "Enter a valid email address!";
            }

    }
        else
            {
                echo "All fields are required!";
            }

?>