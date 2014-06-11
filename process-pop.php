<?

	/* ############### EDIT THESE VARIABLES... ########################################################### */

	$url = 'www.versatilevenues.co.uk'; //Leave out 'http://' and closing slash (change to live url when launching)
	$domain = 'www.versatilevenues.co.uk'; //Root domain
	$emaildomain = 'versatilevenues.co.uk'; //email domain
	$companyname = 'Versatile Venues';
	
	$smtp = array(
      'host'  => 'localhost',
      'port'  => 25,
      'ssl'   => false,
      'user'  => 'contact@versatilevenues.co.uk',
      'pass'  => ')eOAGV{z2_Z['
    );

	$autoresponder = 1; //Send autoresponder email? 0=no, 1=yes
	$autoresponder_name_field = array('pop_Namey'); //Name of name field (If forename/surname use format: array('forename','surname') else just: array('name') ;
	$autoresponder_email_field = 'pop_Email'; //Name of email field
	$autoresponder_subject = "Versatile Venues: quote application confirmation"; //Subject text for autoresponder email
	$autoresponder_message = "<p>Thank you for applying for a quote.</p>"; //Message for autoresponder email (use HTML)
	$autoresponder_details = 1; //Show summary of form contents in autoresponder email? 0=no, 1=yes
	$autoresponder_details_text = "Quote application details:"; //Text to prefix summary (if not showing summary, leave as empty string

	$newsletter_signup = 1; //Include newsletter subscribe code? 0=no, 1=yes
	$elistid = ''; //ElistManager ID no.
	$newsletter_subscribe_field = 'subscribe'; //Name of newsletter subscribe form control
	$newsletter_name_field = array('pop_Namey'); //Name of name field (If forename/surname use format: array('forename','surname') else just: array('name') ;
	$newsletter_email_field = 'pop_Email'; //Name of email field

	$emailsubject = "Quote: New quote application"; //Subject line of email
	$email_content_msg = "The following user has applied for a quote."; //First line of email

	$sendto = "info@versatilevenues.co.uk"; //Change when launching - xxx

	$fields = array(
		"Name" => "pop_Namey",
		"Position" => "pop_Position",
		"Company" => "pop_Company",
		"Email Address" => "pop_Email",
		"Telephone Number" => "pop_Tel",
		"Comments" => "pop_Comments"
	);

	$csv_filename = "quote"; //Must be different for each form on site
	$referrer_alias  = '';
	$redirect = "contact"; //First part of filename of redirect pages (eg. 'contact' [/contact-success.html] [/contact-error.html])
	
	/* #################################################################################################### */
	
	if( ! function_exists('is_valid_referer'))
	{
		function is_valid_referer(array $whitelist = array())
		{
			if( ! isset($_SERVER['HTTP_REFERER']))
			{
				return false;
			}
			
			if( ! isset($_SERVER['HTTP_USER_AGENT']))
			{
				return false;
			}
			
			$referer = $_SERVER['HTTP_REFERER'];
			
			foreach($whitelist as $url)
			{
				$isPattern = $url[0] === '~';
				
				if($isPattern)
				{
					if(preg_match($url, $referer))
					{
						return true;
					}
				}
				
				if($url === $referer)
				{
					return true;
				}
			}
			
			return false;
		}
	}

	if(!function_exists("writeToFile")){
		function writeToFile($input, $filename){
			//function takes an array and saves to a file on one line

			if(!empty($input)){
				//input could be array or just a string
				$content = date("Y-m-d - H:i:s", time()).",";

				if(is_array($input)){
					foreach($input as $column){
						$content .= "\"".str_replace("\"","\"\"",$column)."\",";		
					}
				}else{
					$content .= "\"".str_replace("\"","\"\"",$input)."\",";
				}

				$content = rtrim($content, ",");
				$content .= "\r\n";

				if(file_put_contents($filename, $content, FILE_APPEND)){
					return true;
				}else{
					return false;
				}
			}

			return false;

		}
	}

	if(!function_exists('smtp_mail')){
    function smtp_mail($to, $subject, $body, $headers = null){
      try{
        global $smtp;
        global $emaildomain;
		global $companyname;
        $header_mail = 'contact@' . $emaildomain;
        require_once 'lib-contact/swift_required.php';
        $transport = Swift_SmtpTransport::newInstance();
        $transport->setHost($smtp['host']);
        $transport->setPort($smtp['port']);
        $transport->setUsername($smtp['user']);
        $transport->setPassword($smtp['pass']);
        if($smtp['ssl']){
          $transport->setEncryption('ssl');
        }
        $message = Swift_Message::newInstance($subject);
        $message->setBody($body);
        $message->setTo(array($to));
        $message->setFrom(array($header_mail => $companyname));
        $message->setId($header_mail);
        $message->setReturnPath($header_mail);
        $message->setReplyTo($header_mail);
        $message->setContentType(
          false === stripos($headers, 'text/html') ? 'text/plain' : 'text/html'
        );
        return Swift_Mailer::newInstance($transport)->send($message);
      }catch(Exception $e) { throw $e; }
      return false;
    }
  }

	
	$valid_referers[] = "~http://www.versatilevenues.co.uk/(.+)~";
	$valid_referers[] = "~http://versatilevenues.co.uk/(.+)~";
	$valid_referers[] = "http://versatilevenues.co.uk/";
	$valid_referers[] = "http://www.versatilevenues.co.uk/";
	
	
	if(is_valid_referer($valid_referers)){
		$sendmail = true;
	}

	

	$emailsent = false;
	$buffer= "<p>&nbsp;</p><p align='center'><strong>Sorry, there was an error processing your enquiry. Please try again later.</strong></p>";

	foreach($_POST as $post_name => $post_value) {
		foreach($fields as $fields_label => $fields_name) {
			if($post_name == $fields_name) {
				$new_array[$fields_label] = trim(stripslashes($post_value));
			}
		}
	}

	$EmailContent = "";
	$EmailContent .= $email_content_msg . "\n\n\n";

	foreach($new_array as $new_label => $new_var) {
		$EmailContent .= $new_label . ": " . $new_var . "\n";
	}
		
	$headers = "From: \"contactform@" . $emaildomain . "\" <contactform@" . $emaildomain . ">\r\n";
    $headers .= "Reply-To: \"contactform@" . $emaildomain . "\" <contactform@" . $emaildomain . ">;\r\n";
    $headers .= "X-Sender: \"contactform@" . $emaildomain . "\" <contactform@" . $emaildomain . ">;\r\n";
    $headers .= "X-Mailer: PHP4;\r\n"; //mailer
    $headers .= "X-Priority: 3;\r\n"; //1 UrgentMessage, 3 Normal
    $headers .= "Return-Path: \"contactform@" . $emaildomain . "\" <contactform@" . $emaildomain . ">;\r\n";
    $headers .= "Message-ID: contactform@" . $emaildomain . ";\r\n";
    $headers .= "Content-Type: text/plain;";
	$headers .= "charset=iso-8859-1;\r\n";
	
	if($sendmail == true){
		$filename = $csv_filename . ".csv";
		$output[]= "";

		foreach($new_array as $new_label => $new_var) {
			$output[] .= $new_var;
		}
		@writeToFile($output, $filename);

		if(@smtp_mail($sendto, $emailsubject, $EmailContent,$headers))
		{
			$emailsent = true;
			//******* START autoresponder code *******
			if ($autoresponder == 1) {
				if (count($autoresponder_name_field) > 1) {
					$name = $_POST[$autoresponder_name_field[0]] . " " . $_POST[$autoresponder_name_field[1]];
				}
				else {
					$name = $_POST[$autoresponder_name_field[0]];
				}
				$thankyou = "<p>Dear " . $name . ",</p>" . $autoresponder_message;

				if ($autoresponder_details == 1) {
					$thankyou .= "<p>-----------------------------------</p>";
					$thankyou .= "<p><strong>" . $autoresponder_details_text . "</strong></p>";
					$thankyou .= "<p>";

					foreach($new_array as $new_label => $new_var) {
						$thankyou .= "<strong>" . $new_label . ":</strong> " . $new_var . "<br />";
					}
					$thankyou .= "</p>";
				}
				@smtp_mail($_POST[$autoresponder_email_field], $autoresponder_subject, $thankyou, "From: contactform@" . $emaildomain . "\nContent-Type: text/html; charset=iso-8859-1");
			}
			//******* END autoresponder code *******


			if ($newsletter_signup == 1) { //If there is newsletter signup functionality on the form
				if ($_POST[$newsletter_subscribe_field] == 'Yes' || $_POST[$newsletter_subscribe_field] == 'on' || $_POST[$newsletter_subscribe_field] == 1) { //If they've asked to be subscribed to the newsletter

					require_once("../../cms/header.php");
					require_once("../../cms/class.newsletter.php");
					
					$newsletter = new newsletter();
					$newsletter->setElistId($elistid);
					$newsletter->setEmail($_POST[$newsletter_email_field]);

					if (count($newsletter_name_field) > 1) {
						$newsletter->setName($_POST[$newsletter_name_field[0]] . " " . $_POST[$newsletter_name_field[1]]);
					}
					else {
						$newsletter->setName($_POST[$newsletter_name_field[0]]);
					}
					$newsletter->Subscribe();
				}				
			}
			 
		}	
	}

	else
	{
		$filename = $csv_filename . "-spam.csv";
		@writeToFile($output, $filename);
	}

	if($emailsent == true)
	{
		header("Location: http://" . $url . "/" . $redirect . "/thanks");	//-success.html
	}
	else
	{
		header("Location: http://" . $url . "/" . $redirect . "/error");	//-fail.html
	}
?>