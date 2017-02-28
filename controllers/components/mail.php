<?php 
class MailComponent extends Object
{
    var $senderMail = "@.co.il";
    var $controller = true;
 
    function startup(&$controller)
    {
        // This method takes a reference to the controller which is loading it.
        // Perform controller initialization here.
    }
 
    function sendMail($subject,$details,$email_to = "",$from){
        //$email_from = $this->senderMail; // Who the email is from
        $email_from = $from; // Who the email is from
		$email_subject = $subject; // The Subject of the email
		$email_txt = ""; // Message that the email has in it
		$headers = "From: ".$email_from;
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		$headers .= "\nMIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$mime_boundary}\"";
		$email_message="";
		$email_message .=$details;
		$email_message .= "This is a multi-part message in MIME format.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type:text/html; charset=\"UTF-8\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		$email_message . "\n\n";
		$ok = @mail($email_to,$email_subject,$email_message,$headers);
    }
    function sendMailAttach($subject,$details,$email_to = "",$from,$fileatt="",$fileNameToMail=""){
		$fileatt_type = filetype($fileatt); // File Type
		$fileatt_name = $fileNameToMail; // Filename that will be used for the file as the attachment
		$email_from = $from; // Who the email is from
		$email_subject = $subject; // The Subject of the email
		$email_txt = $details; // Message that the email has in it
		$headers = "From: ".$email_from;
		$file = fopen($fileatt,'rb');
		$data = fread($file,filesize($fileatt));
		fclose($file); 
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		$headers .= "\nMIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$mime_boundary}\"";
		$email_message=$email_txt;
		$email_message = nl2br($email_message);
		$email_message .= "This is a multi-part message in MIME format.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type:text/html; charset=\"windows-1255\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		$email_message . "\n\n";
		$data = chunk_split(base64_encode($data));
		$email_message .= "--{$mime_boundary}\n" .
		"Content-Type: {$fileatt_type};\n" .
		" name=\"{$fileatt_name}\"\n" .
		//"Content-Disposition: attachment;\n" .
		//" filename=\"{$fileatt_name}\"\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n" .
		"--{$mime_boundary}--\n";
		$ok = @mail($email_to, $email_subject, $email_message, $headers);
	}

    function valid_email($email) {
	  // First, we check that there's one @ symbol, and that the lengths are right
	  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
	    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
	    return false;
	  }
	  // Split it into sections to make life easier
	  $email_array = explode("@", $email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++) {
	     if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
	      return false;
	    }
	  }  
	  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
	    $domain_array = explode(".", $email_array[1]);
	    if (sizeof($domain_array) < 2) {
	        return false; // Not enough parts to domain
	    }
	    for ($i = 0; $i < sizeof($domain_array); $i++) {
	      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
	        return false;
	      }
	    }
	  }
	  return true;
	} 
}
?>