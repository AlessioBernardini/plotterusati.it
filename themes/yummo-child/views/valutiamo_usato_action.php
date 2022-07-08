<?php 

    if(isset($_POST)){
        foreach($_POST as $campo){
            echo $campo."<br/>";
        }
    }

    $to      = 'adv@trendsrl.net';
    $subject = 'Richiesta valutazione usato dal sito www.plotterusati.it';
    $message = 'hello';
    $headers = 'From: webmaster@example.com'       . "\r\n" .
                 'Reply-To: webmaster@example.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

?>