<?php
		// BEGIN PREPERATION OF EMAIL
	function sendMessage($to,$from,$subject,$message){	
		require_once ('include/emailer.php');
		require_once ('config/amazonlogin.php');
		$sentEmail = Email::send($to, $from, $subject, $message);
	}

?>