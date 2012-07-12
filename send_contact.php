<?php
// Contact subject
$subject = $_POST['subject'];
// Details
$message="Judul Buku : ".$_POST['buku']." \n\n\n Balas email ini ke ".$_POST['nama']." <".$_POST['dari']."> \n\n\n Contact Person : ".$_POST['hp']." \n\n\n Dengan Alamat : ".$_POST['alamat']."\n\n\n ".$_POST['detail'];

// Mail of sender
$mail_from=$_POST['dari'];
// From
$head="From: ".$_POST['nama']. " <".$mail_from.">";

// Enter your email address
$to ='f4ztr1k@yahoo.co.id, adha.nurfalah@gmail.com';

$send_contact=mail($to,$subject,$message,$head);

// Check, if message sent to your email
// display message "We've recived your information"
if($send_contact){
echo "<div align=\"center\" style=\"background:#ffffff;\">Email dari anda sudah terkirim<br>Akan kami proses secepatnya<br>Terima Kasih</div>";
}
else {
echo "ERROR";
}
?>