<?php
		// BEGIN PREPERATION OF EMAIL

	function checkAttachment(){
		$allowedExts = array("gif", "jpeg", "jpg", "png","pdf","doc","docx","xlsx","ppt");
		$temp = explode(".", $_FILES["attachment"]["name"]);
		$extension = strtolower(end($temp));
		if ((($_FILES["attachment"]["type"] == "image/gif")
		|| ($_FILES["attachment"]["type"] == "image/jpeg")
		|| ($_FILES["attachment"]["type"] == "image/jpg")
		|| ($_FILES["attachment"]["type"] == "image/pjpeg")
		|| ($_FILES["attachment"]["type"] == "application/msword")
		|| ($_FILES["attachment"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		|| ($_FILES["attachment"]["type"] == "application/vnd.ms-excel")
		|| ($_FILES["attachment"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
		|| ($_FILES["attachment"]["type"] == "application/vnd.ms-powerpoint")
		|| ($_FILES["attachment"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
		|| ($_FILES["attachment"]["type"] == "application/msexcel")
		|| ($_FILES["attachment"]["type"] == "application/x-msexcel")
		|| ($_FILES["attachment"]["type"] == "application/x-ms-excel")
		|| ($_FILES["attachment"]["type"] == "application/x-excel")
		|| ($_FILES["attachment"]["type"] == "application/x-dos_ms_excel")
		|| ($_FILES["attachment"]["type"] == "application/xls")
 		|| ($_FILES["attachment"]["type"] == "application/x-xls")
		|| ($_FILES["attachment"]["type"] == "image/x-png")
		|| ($_FILES["attachment"]["type"] == "application/pdf")

		|| ($_FILES["attachment"]["type"] == "image/png"))
		// && ($_FILES["attachment"]["size"] < 1000000000)
		&& in_array($extension, $allowedExts))
		  {
		  if ($_FILES["attachment"]["error"] > 0)
		    {
		    echo "Return Code: " . $_FILES["attachment"]["error"] . "<br>";
		    return false;
		    }
		  else
		    {
		      move_uploaded_file($_FILES["attachment"]["tmp_name"],"upload/" . $_FILES["attachment"]["name"]);
		      $fullTmpPath = FILEPATH . "upload/" . $_FILES["attachment"]["name"];
		      return $fullTmpPath;
		    }
		  }
		else
		  {
		  echo "Invalid file. Contact mwenger@michaeljfox.org or try submitting the form with a different file type.";
		  die();
		  return false;
  		}
	}


	function sendMessage($to,$from,$subject,$message,$attachment=false){

		require_once ('include/emailer.php');
		require_once ('config/amazonlogin.php');

		if ($attachment){
			$successfulAttachment = checkAttachment();
			if ($successfulAttachment){
				$sentEmail = Email::send($to, $from, $subject, $message, $successfulAttachment);
			}
		}else {
			$sentEmail = Email::send($to, $from, $subject, $message);
		}

	}

?>
