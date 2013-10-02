<?php
		// BEGIN PREPERATION OF EMAIL
		require_once ('include/emailer.php');
		require_once ('config/amazonlogin.php');


		$subject = "Test email";

		$htmlMessage = "<div style='width:550px; margin:0 auto;'>";
		$htmlMessage .= "<img src='https://www.michaeljfox.org/images/logo-ppmi.jpg' /> ";
		$htmlMessage .= "<p>Hey Mike,</p>";
		$htmlMessage .= "<p>My test message worked.";
		$htmlMessage .= "</div>";

		$to = "michaelwenger27@gmail.com";

		$sentEmail = Email::send($to, 'mwenger@michaeljfox.org', $subject, $htmlMessage);

		if ($sentEmail) {
			echo "Email sent successfully";
		} else {
			echo "Email failed";
		}


?>