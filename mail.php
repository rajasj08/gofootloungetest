<?php
$to      = 'balajic133@gmail.com';
$subject = 'the subject';
$message = 'hello<br/><p>Hai</p>';
$headers = 
'MIME-Version: 1.0' . "\r\n".
'From: webmaster@example.com' . "\r\n" .
'Content-type: text/html; charset=iso-8859-1' . "\r\n".
    
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>  