<?php
	//require_once "Mail.php";
	$dbname="FinalProject";
  	$servername="localhost";
  	$username="root";
  	$password="";
  	$conn=mysqli_connect($servername,$username,$password,$dbname);

  	$date=$_POST['date'];
  	$prob=$_POST['prob'];
  	$did=$_POST['did'];

  	echo $date."<br>".$prob."<br>";
  	$cookiename=md5('p');
    if(isset($_COOKIE[$cookiename]))
    {
        $username=$_COOKIE['usernamepat'];
        $sql="insert into Appointment (PatientUsrName,StaffUsrName,Date,Status,Description) values ('$username','$did','$date',false,'$prob')";
        $result=mysqli_query($conn,$sql);
        echo "Hello"."<br>";
        $sql2="select * from Appointment where PatientUsrName='$username' AND StaffUsrName='$did' AND Date='$date' order by Date desc limit 1";
        $result2=mysqli_query($conn,$sql2);
        $app="";
        while($row1=mysqli_fetch_assoc($result2))
        {
        	$app=$row1['AppointmentID'];
        }
        echo $username."<br>".$did."<br>".$app;
        $sql1="select * from Doctor where Username='$did'";
        $result1=mysqli_query($conn,$sql1);
        while($row=mysqli_fetch_assoc($result1)){
        	echo "<br>Hello";
        	echo "<br>".$row['Email'];
       		$from = "no_reply@hospital.in";
 			$to = $row['Email'];
 			$subject = "An appointment generated!";
 			$body = "Hi, An appointment has been generated by ".$username.". To view the appointment, please go to your portal.AppointmentID is ".$app;
 			$host = "mail.students.iitmandi.ac.in";
 			$username = "abhishek_a_s";
 			$password = "";

 			$headers = array ('From' => $from,'To' => $to,'Subject' => $subject);
 			$smtp = Mail::factory('smtp',array ('host' => $host,'auth' => true,'username' => $username,'password' => $password));
 
 			if (PEAR::isError($smtp)) {
   				echo("<p>" . $smtp->getMessage() . "</p><p>".$smtp->getUserInfo()."</p>");
   				die;
  			} 
  			else {
   				echo("<p>Message successfully sent!</p>");
  			}

 			$mail = $smtp->send($to, $headers, $body, "From: ".$from);
 
 			if (PEAR::isError($mail)) {
   			echo("<p>" . $mail->getMessage() . "</p>");
  			}
  			else {
				echo("<p>Appointment id generated ".$app."</p>");
  			}
    	}
	}
?>