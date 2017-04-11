<?php 

/*
$servername = "localhost";
$username = "footlounge_footn";
$password = "Welcome!23";
$dbname = "footlounge_010317";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//$sql = "SELECT a.order_status_id,a.date_added,a.date_modified,a.order_id,a.email,a.firstname,a.lastname FROM `oc_order` as a left join oc_order_status as b on b.order_status_id=a.order_status_id where b.name='completed' and (DATE(a.date_modified)=CURDATE() OR DATE(a.date_modified) =DATE_SUB(CURDATE(), INTERVAL 1 DAY) OR DATE(a.date_modified) =DATE_SUB(CURDATE(), INTERVAL 2 DAY))";

//$sql = "INSERT INTO  `testtbl` (  `message` ) VALUES ('test')"; 


  
$result = $conn->query($sql); 
      
 $message1= htmlentities(file_get_contents("http://testourwork.com/footlounge/newmail.html"));   
         $message1=html_entity_decode($message1); 
         $tomail='rselakki@yahoo.com';   
         $row=1; 
 while($row<3) { 
         if($tomail)
        { 
         
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: order@footlounge.in'."\r\n".
            //$headers .= 'From: rselakki@gmail.com'."\r\n".
            //'CC: rajesh@tech-bee.comm'.
            //'Reply-To: '.$emailid."\r\n" .
            'X-Mailer: PHP/' . phpversion();


            // Create email headers$emailid
            
          // if( mail('Pooja_khatri@yahoo.com', 'Email Notification Request Received', $str1, $headers))
         if( mail($tomail, 'Welcome Message', $message1, $headers))
         { echo "Mail Send Successfully";  $row++;} else echo 0;         
 
        }  
    }

$conn->close(); */ 




?>

<?php 

$servername = "aa123cnq8bv20jg.cvwrkeif9dtm.ap-south-1.rds.amazonaws.com";
$username = "fladmin";
$password = "Welcome!23";
$dbname = "ebdb";
/*
$servername = "localhost";
$username = "foot_footnew";
$password = "Welcome!23";
$dbname = "footlounge_120116";*/


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//$sql = "SELECT a.order_status_id,a.date_added,a.date_modified,a.order_id,a.email,a.firstname,a.lastname FROM `oc_order` as a left join oc_order_status as b on b.order_status_id=a.order_status_id where b.name='completed' and (DATE(a.date_modified)=CURDATE() OR DATE(a.date_modified) =DATE_SUB(CURDATE(), INTERVAL 1 DAY) OR DATE(a.date_modified) =DATE_SUB(CURDATE(), INTERVAL 2 DAY))";


/* Origional query*/

$sql = "SELECT a.order_status_id,a.date_added,a.date_modified,a.order_id,a.email,a.firstname,a.lastname FROM `oc_order` as a left join oc_order_status as b on b.order_status_id=a.order_status_id where b.name='completed' and DATE(a.date_modified) = DATE_SUB(CURDATE(), INTERVAL 4 DAY)";

/*$sql = "SELECT a.order_status_id,a.date_added,a.date_modified,a.order_id,a.email,a.firstname,a.lastname FROM `oc_order` as a left join oc_order_status as b on b.order_status_id=a.order_status_id where DATE(a.date_modified) = DATE_SUB(CURDATE(), INTERVAL 6 DAY)"; */



$result = $conn->query($sql); 

 
      $count=1;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {  
      
      if($row['email']) {$tomail=trim($row['email']);} else $tomail=''; 

       $message1= htmlentities(file_get_contents("http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/newmail.html"));   
         $message1=html_entity_decode($message1);    

         if($tomail)
        {  
          
          
          $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
          $headers .= 'From: FootLounge <order@footlounge.in>'."\r\n".
          //$headers .= 'From: rselakki@gmail.com'."\r\n".
          //'CC: rajesh@tech-bee.comm'.
        //'Reply-To: '.$emailid."\r\n" .
        'X-Mailer: PHP/' . phpversion(); 


          // Create email headers$emailid
      
        // if( mail('Pooja_khatri@yahoo.com', 'Email Notification Request Received', $str1, $headers))
       if( mail($tomail, 'Thank You for Shopping ! Review Us to Earn a Free Pair of Socks', $message1, $headers))
       { $count++;} else echo 0;         
 
        }  

    }

    if($count >1){ echo "Notification mail send successfully to the customers"; } 
} else {
    echo "No Mail Send";}
$conn->close();

?>