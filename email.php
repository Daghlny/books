<?php
require ("../PHPMailer_5.2.4/class.phpmailer.php");
class email{
    function mail($name, $subject, $body, $address){

         $mail= new PHPMailer(); //建立新物件 
         $mail->IsSMTP(); //設定使用SMTP方式寄信 
         $mail->SMTPAuth = true; //設定SMTP需要驗證 
         $mail->Host = "smtp.qq.com"; //設定SMTP主機 
         $mail->Port = 465; //設定smtp端口。 
         $mail->SMTPSecure = 'ssl';
         $mail->CharSet = "utf8"; //設定郵件編碼 
         $mail->Username = "707807852@qq.com"; //設定驗證帳號 
         $mail->Password = "huakeqmk214"; //設定驗證密碼 
         $mail->From = "707807852@qq.com"; //設定寄件者信箱 
         $mail->FromName = "$name"; //設定寄件者姓名 
         $mail->Subject = "$subject"; //設定郵件標題 
         $mail->Body = "$body"; //設定郵件內容 
         $mail->IsHTML(true); //設定郵件內容為HTML 
         $mail->AddAddress("$address", "test"); //設定收件者郵件及名稱
         if(!$mail->Send()) { 
             echo "Mailer Error: " . $mail->ErrorInfo; 
             $result=0;
         }
         else{
             $result=1;
         }
         return $result; 
    }
}
?>
         
