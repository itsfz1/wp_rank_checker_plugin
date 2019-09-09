<?php
//get the email
$email = get_option('rcl-second');
if($email == ""){
echo '</h3>Please set your email!</h3>';
die;
}
// the message
if($found){
$msg = "<h3>Keyword ['.$keyword.'] is on page number '.$pagenum.' on google</h3>\n<h3>And on page position is '.($pagerank+1).'</h3>";
}
else{
$msg = '<h3>Your site is not found! in top 10 results of google for this '.$keyword .'</h3>';
}
// send email
if(mail($email,"Rank Checker Light Updates!",$msg)){
echo '<h3>Mail sent successfully!</h3>';
}
else{
echo '<h3>Mail not sent :( check your mail.php file</h3>';
}
?>