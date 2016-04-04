<?php
         $to = "biri@knights.ucf.edu";
		 $subject = "COP4710 Automated Email - Test";
         
         $message .= "<h1>Email Heading</h1>";
		 $message .= "<p>This is an automated email send by visiting the webpage www.raspbiripi.ddns.net/mailtest.php</p>";
         $message .= "<p>Let me know if you got these emails</p>";

         $header = "From:abc@somedomain.com \r\n";
         $header .= "Cc:afgh@somedomain.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
?>
