<?php
		// BEGIN PREPERATION OF EMAIL

	function checkAttachment(){
		$allowedExts = array("gif", "jpeg", "jpg", "png","pdf","doc","docx");
		$temp = explode(".", $_FILES["attachment"]["name"]);
		$extension = end($temp);
		if ((($_FILES["attachment"]["type"] == "image/gif")
		|| ($_FILES["attachment"]["type"] == "image/jpeg")
		|| ($_FILES["attachment"]["type"] == "image/jpg")
		|| ($_FILES["attachment"]["type"] == "image/pjpeg")
		|| ($_FILES["attachment"]["type"] == "application/msword")
		|| ($_FILES["attachment"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		
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
		    if (file_exists("upload/" . $_FILES["attachment"]["name"]))
		      {
		      echo $_FILES["attachment"]["name"] . " already exists. ";
		      return false;
		      }
		      
		    else
		      {
		      move_uploaded_file($_FILES["attachment"]["tmp_name"],"upload/" . $_FILES["attachment"]["name"]);
		      return $FILEPATH . "/upload/" . $_FILES["attachment"]["name"];
		      }
		    }
		  }
		else
		  {
		  echo "Invalid file";
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