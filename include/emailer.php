<?php
/**
 *
 * @package    Swift4.3.0
 */

require_once('swiftmailer/swift_required.php');


class Email {

	// SwiftMailer instance
	protected static $mail;
	
	/**
	 * Creates a SwiftMailer instance.
	 *
	 * @param   string  DSN connection string
	 * @return  object  Swift object
	 */
	public static function connect($config = NULL)
	{
		// Load default configuration
		if ($config === NULL) die('No config defined');

		switch ($config['driver'])
		{
			case 'smtp':
				// Set port
				$port = empty($config['options']['port']) ? 25 : (int) $config['options']['port'];

				// Create SMTP Transport
				$transport = Swift_SmtpTransport::newInstance($config['options']['hostname'], $port);

				if ( ! empty($config['options']['encryption']))
				{
					// Set encryption
					$transport->setEncryption($config['options']['encryption']);
				}

				// Do authentication, if part of the DSN
				empty($config['options']['username']) or $transport->setUsername($config['options']['username']);
				empty($config['options']['password']) or $transport->setPassword($config['options']['password']);

				// Set the timeout to 5 seconds
				$transport->setTimeout(empty($config['options']['timeout']) ? 5 : (int) $config['options']['timeout']);
			break;
			case 'sendmail':
				// Create a sendmail connection
				$transport = Swift_SendmailTransport::newInstance(empty($config['options']) ? "/usr/sbin/sendmail -bs" : $config['options']);

			break;
			default:
				// Use the native connection
				$transport = Swift_MailTransport::newInstance($config['options']);
			break;
		}

		// Create the SwiftMailer instance
		return Email::$mail = Swift_Mailer::newInstance($transport);
	}

    
	/**
	 * Send an email message.
	 *
	 * @param   string|array  recipient email (and name), or an array of to, cc, bcc, reply-to names
	 *                         - a single string email address e.g. "test@example.com"
	 *                         - an array specifying an email address and a name e.g. array('test@example.com', 'John Doe')
	 *                         - an array of recipients in either above format, keyed by type e.g. array('to' => 'test@example.com', 'cc' => array('test2@example.com', 'Jane Doe'), 'bcc' => 'another@example.com')
     *                         - when using array of recipients with key 'to', it calls Swift_Message::setTo() directly
	 * @param   string|array  sender email (and name)
	 * @param   string        message subject
	 * @param   string        message body
	 * @param   boolean       send email as HTML
	 * @return  integer       number of emails sent
	 */
	public static function send($to, $from, $subject, $message, $attachment = FALSE, $html = TRUE)
	{
        $recipientCount = 0;
        try{
    		// Connect to SwiftMailer
    		(Email::$mail === NULL) and email::connect();
    
    		// Determine the message type
    		$html = ($html === TRUE) ? 'text/html' : 'text/plain';
    
    		// Create the message
    		$message = Swift_Message::newInstance($subject, $message, $html, 'utf-8');
    
    		if (is_string($to))
    		{
    			// Single recipient
    			$message->setTo($to);
    		}
    		elseif (is_array($to))
    		{
    			if (isset($to[0]) AND isset($to[1]))
    			{
    				// Create To: address set
    				$to = array('to' => array($to[0] => $to[1]));
    			}
    
    			foreach ($to as $method => $set)
    			{
    				if (in_array($method, array('cc', 'bcc'), true))
    				{
    				    // use add over set, so we add to the recipient list instead of override it
        				$method = 'add'.ucfirst($method);
    				}
    				else if ($method === 'reply-to')
    				{
    	    			$method = 'setReplyTo';
    				}
    				else
    				{
    					// Use To: by default
    					// Note: The setTo() method accepts input in various formats as described earlier in this chapter. 
    					//       The addTo() method takes either one or two parameters. 
    					//       The first being the email address and the second optional parameter being the name of the recipient.
    					$method = 'setTo';
    				}
    
    
    				if ($method === 'setTo')
    				{
    	    			$message->setTo($set);
    				}
    				else
    				{
        				if (is_array($set))
        				{
        					// Add a recipient with name
        					$message->$method($set[0], $set[1]);
        				}
        				else
        				{
        					// Add a recipient without name
        					$message->$method($set);
        				}
    				}
    			}
    		}
    
    		if (is_string($from))
    		{
    			// From without a name
    			$message->setFrom($from);
    		}
    		elseif (is_array($from))
    		{
    			// From with a name
    			$message->setFrom($from[0], $from[1]);
    		}

            if ($attachment){
                // $file = $_FILES["attachment"]["tmp_name"]; //"attachment" is the name of your input field, "tmp_name" gets the temporary path to the uploaded file.
                // $filename = $_FILES["attachment"]["name"];
                    // From without a name
                // $filename = "vanityurls.txt";
                // $file = $filePath . $filename;
                $message->attach(Swift_Attachment::fromPath($attachment));
                // $message->attach(new Swift_Message_Attachment(new Swift_File($file), $filename));
            
            }
    
    		$recipientCount = Email::$mail->send($message);
        }catch (Swift_TransportException $e){
            echo "Swift_TransportException.  Message: ".$e->getMessage();
        }catch (Swift_MimeException $e){
            echo "Swift_MimeException.  Message: ".$e->getMessage();
        }catch (Swift_RfcComplianceException $e){
            echo "Swift_RfcComplianceException.  Message: ".$e->getMessage();
        }

		return $recipientCount;
	}

} // End email