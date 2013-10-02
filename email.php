<?php
		// BEGIN PREPERATION OF EMAIL
		require_once ('include/emailer.php');
		require_once ('config/amazonlogin.php');


		// loop
		$firstNameTest = $row['firstname'];

		$htmlMessage = "<div style='width:550px; margin:0 auto;'>";
		$htmlMessage .= "<img src='https://www.michaeljfox.org/images/logo-ppmi.jpg' /> ";
		$htmlMessage .= "<p>" . $firstNameTest . ",</p>";

		// EMAIL COPY FOR MATCH

		if($emailLanguage == "italy"){
			if ($match_status && !$wrong_zip) {
				//$errorMessage .= $row['firstname'] . " matches " . (($wrong_zip) ? "nothing<br/>" : "" . $match_site . " <br/>");
				$insertQuery = "INSERT INTO match1 (`subject_id`, `match_status`, `email_sent`, `matched_locations`,`too_young`,`has_pd`,`has_dementia`,`wrong_zip`) VALUES ('" . $row['subject_id'] . "','eligible','1','" . $match_site . "','0','0','0','0')";

				$htmlMessage .= "<p>La ringrazio per il recente interesse dimostrato per la ricerca sul test olfattivo mirante a valutare il senso dell'olfatto e il suo rapporto con disturbi neurologici, quali la malattia di Parkinson. Le siamo grati per il tempo che ha dedicato a rispondere all'indagine di ricerca sull'olfatto.</p>";
				$htmlMessage .= "<p>Le informazioni che ci ha fornito saranno utili per determinare se Lei è in possesso dei requisiti necessari per partecipare allo studio. Il gruppo di ricerca esaminerà i dati e Le farà sapere se Lei è candidato ad una ulteriore partecipazione. Nel caso Lei sia un potenziale candidato, il gruppo di ricerca Le invierà per posta ulteriori informazioni e materiali sulla ricerca.</p>";
				$htmlMessage .= "<p>La ringraziamo ancora per il tempo che ha dedicato a questo progetto e Le esprimiamo il nostro grande apprezzamento per il supporto che ha dato alla nostra ricerca.</p>";
				$htmlMessage .= "<p>Cordiali saluti,<br/>Gruppo di Ricerca sul Test Olfattivo, Institute for Neurodegenerative Disorders</p>";
				$subject = "Risposta relativa all'indagine sull'olfatto a cui ha partecipato";
			} else {
				//$errorMessage .= $row['firstname'] . " doesnt match." . (($too_young) ? ' too young,' : '') . (($has_pd) ? 'has pd,' : '') . (($has_dementia) ? ' has dementia' : '') . "<br/>";
				$insertQuery = "INSERT INTO match1 (`subject_id`, `match_status`, `email_sent`, `too_young`, `has_pd`, `has_dementia`, `wrong_zip`) VALUES ('" . $row['subject_id'] . "','disqualified','1','" . (($too_young) ? '1' : '0') . "','" . (($has_pd) ? '1' : '0') . "','" . (($has_dementia) ? '1' : '0') . "','" . (($wrong_zip) ? '1' : '0') . "')";

				$htmlMessage .= "<p>La ringrazio per il recente interesse dimostrato per la ricerca sul test olfattivo mirante a valutare il senso dell'olfatto e il suo rapporto con disturbi neurologici, quali la malattia di Parkinson. Le siamo grati per il tempo che ha dedicato alla compilazione del documento di indagine di carattere generale. Sulla base dei criteri specifici per l'ammissione alla ricerca, Lei non ha al momento i requisiti per la partecipazione.</p>";
				$htmlMessage .= "<p>Conserveremo tuttavia le informazioni che La riguardano nel nostro archivio e potremo prendere contatto con Lei in futuro, se ci saranno variazioni sui requisiti di ammissibilità o se verranno avviati altri progetti per i quali Lei avrà i requisiti.</p>";
				$htmlMessage .= "<p>La ringraziamo ancora per il tempo che ha dedicato a questo progetto e Le esprimiamo il nostro grande apprezzamento per il supporto che ha dato alla nostra ricerca. </p>";
				$htmlMessage .= "<p>Cordiali saluti,<br/>Gruppo di Ricerca sul Test Olfattivo, Institute for Neurodegenerative Disorders</p>";
				$htmlMessage .= "<p>PS: Siamo continuamente alla ricerca di pazienti affetti da Parkinson e persone non affette da Parkinson - sia familiari di pazienti, sia persone che non hanno alcun grado di parentela con qualcuno affetto da Parkinson. Per maggiori informazioni sulle sperimentazioni nella Sua zona, che richiedano persone con le Sue caratteristiche, visiti il sito <a href='http://www.foxtrialfinder.org'>www.foxtrialfinder.org.</a> </p>";
				$subject = "Risposta relativa all'indagine sull'olfatto a cui ha partecipato";
			}
		} elseif($emailLanguage == "germany"){
			if ($match_status && !$wrong_zip) {
				//$errorMessage .= $row['firstname'] . " matches " . (($wrong_zip) ? "nothing<br/>" : "" . $match_site . " <br/>");
				$insertQuery = "INSERT INTO match1 (`subject_id`, `match_status`, `email_sent`, `matched_locations`,`too_young`,`has_pd`,`has_dementia`,`wrong_zip`) VALUES ('" . $row['subject_id'] . "','eligible','1','" . $match_site . "','0','0','0','0')";

				$htmlMessage .= "<p>Vielen Dank für Ihr jüngstes Interesse an der Riechtest-Studie, die den Geruchssinn und seine Beziehung zu neurologischen Störungen, wie z. B. Parkinsonkrankheit, beurteilt. Wir danken Ihnen dafür, dass Sie sich die Zeit genommen haben, die Befragung zur Riechtest-Studie zu beantworten.</p>";
				$htmlMessage .= "<p>Die von Ihnen bereitgestellten Informationen sind nützlich für die Feststellung, ob Sie an dieser Studie teilnehmen können. Das Studienteam wird die Erhebungsdaten prüfen und Sie im Nachgang informieren, ob Sie als Kandidat für eine weitere Teilnahme in Frage kommen. Wenn Sie ein potenzieller Kandidat sind, lässt das Studienteam Ihnen weitere Studieninformationen und -materialien zukommen.</p>";
				$htmlMessage .= "<p>Wir danken Ihnen nochmals für die Zeit, die Sie auf dieses Projekt aufgewendet haben. Wir schätzen Ihre Mithilfe bei unserer Forschungsstudie sehr.</p>";
				$htmlMessage .= "<p>Mit freundlichem Gruß,<br/>Das Studienteam der Riechtest-Studie des IND  </p>";
				$subject = "Antwort auf Ihr Erhebungsformular zu Geruchssinn";
			} else {
				//$errorMessage .= $row['firstname'] . " doesnt match." . (($too_young) ? ' too young,' : '') . (($has_pd) ? 'has pd,' : '') . (($has_dementia) ? ' has dementia' : '') . "<br/>";
				$insertQuery = "INSERT INTO match1 (`subject_id`, `match_status`, `email_sent`, `too_young`, `has_pd`, `has_dementia`, `wrong_zip`) VALUES ('" . $row['subject_id'] . "','disqualified','1','" . (($too_young) ? '1' : '0') . "','" . (($has_pd) ? '1' : '0') . "','" . (($has_dementia) ? '1' : '0') . "','" . (($wrong_zip) ? '1' : '0') . "')";

				$htmlMessage .= "<p>Vielen Dank für Ihr jüngstes Interesse an einer Teilnahme an der Riechtest-Studie, die den Geruchssinn und seine Beziehung zu neurologischen Störungen, wie z. B. Parkinsonkrankheit, beurteilt. Wir danken Ihnen dafür, dass Sie sich die Zeit genommen haben, die Hintergrund-Erhebung zu beantworten. Auf der Grundlage der spezifischen Studien-Aufnahmekriterien sind Sie zu diesem Zeitpunkt nicht für eine Teilnahme qualifiziert.</p>";
				$htmlMessage .= "<p>Wir werden Ihre Informationen aufbewahren und eventuell in Zukunft Kontakt mit Ihnen aufnehmen, wenn sich die Qualifikationskriterien ändern oder andere Projekte gestartet werden, für die Sie möglicherweise in Frage kommen. </p>";
				$htmlMessage .= "<p>Wir danken Ihnen nochmals für die Zeit, die Sie auf dieses Projekt aufgewendet haben. Wir schätzen Ihre Mithilfe bei unserer Forschungsstudie sehr.</p>";
				$htmlMessage .= "<p>Mit freundlichem Gruß,<br/>Das Studienteam der Riechtest-Studie des IND </p>";
				$htmlMessage .= "<p>PS: Es besteht ein ständiger Bedarf an Parkinson-Patienten und  an Nicht-Parkinson Erkrankten – Familienmitglieder von Patienten sowie Personen, die in keiner Verbindung zu einem Parkinson-Patienten stehen – für Forschungsstudien. Auf <a href='http://www.foxtrialfinder.org'>www.foxtrialfinder.org.</a> finden Sie nähere Informationen zu Studien in Ihrer Gegend, für die Personen wie Sie gesucht werden. </p>";
				$subject = "Antwort auf Ihr Erhebungsformular zu Geruchssinn";
			}
		} else {
			if ($match_status && !$wrong_zip) {
				//$errorMessage .= $row['firstname'] . " matches " . (($wrong_zip) ? "nothing<br/>" : "" . $match_site . " <br/>");
				$insertQuery = "INSERT INTO match1 (`subject_id`, `match_status`, `email_sent`, `matched_locations`,`too_young`,`has_pd`,`has_dementia`,`wrong_zip`) VALUES ('" . $row['subject_id'] . "','eligible','1','" . $match_site . "','0','0','0','0')";

				$htmlMessage .= "<p>Thank you for your recent interest in the smell test study which is evaluating the sense of smell and its relationship to neurological disorders such as Parkinson disease. We appreciate the time you have spent completing the smell test study survey.</p>";
				$htmlMessage .= "<p>The information you have provided is helpful in determining if you would be able to participate in this study. The study team will review the survey data and follow-up to let you know if you are candidate to participate further. Should you be a potential candidate, the study team will mail you additional study information and materials.</p>";
				$htmlMessage .= "<p>Again, we thank you for the time you have spent on this project and greatly appreciate your support of our research.</p>";
				$htmlMessage .= "<p>Sincerely,<br/>The Smell Test Study Team at IND </p>";
				$subject = "Response to your Smell Survey";
			} else {
				//$errorMessage .= $row['firstname'] . " doesnt match." . (($too_young) ? ' too young,' : '') . (($has_pd) ? 'has pd,' : '') . (($has_dementia) ? ' has dementia' : '') . "<br/>";
				$insertQuery = "INSERT INTO match1 (`subject_id`, `match_status`, `email_sent`, `too_young`, `has_pd`, `has_dementia`, `wrong_zip`) VALUES ('" . $row['subject_id'] . "','disqualified','1','" . (($too_young) ? '1' : '0') . "','" . (($has_pd) ? '1' : '0') . "','" . (($has_dementia) ? '1' : '0') . "','" . (($wrong_zip) ? '1' : '0') . "')";

				$htmlMessage .= "<p>Thank you for your recent interest in participating in the smell test study which is evaluating the sense of smell and its relationship to neurological disorders such as Parkinson disease. We appreciate the time you have spent completing the background survey.  Based on specific study entry criteria, you are not eligible for participation at this time. </p>";
				$htmlMessage .= "<p>We will keep your information on file, and we may contact in the future if eligibility requirements change or other projects arise that you may be eligible for. </p>";
				$htmlMessage .= "<p>Again, we thank you for the time you have spent on this project and greatly appreciate your support of our research. </p>";
				$htmlMessage .= "<p>Sincerely,<br/>The Smell Test Study Team at IND </p>";
				$htmlMessage .= "<p>PS- Parkinson’s patients and people without Parkinson’s—family members of patients as well as people who have no relation to someone with Parkinson’s – are needed for research all of the time. To learn more about trials in your area looking for someone like you, visit <a href='http://www.foxtrialfinder.org'>www.foxtrialfinder.org.</a> </p>";
				$subject = "Response to your Smell Survey";
			}			
		}


		$htmlMessage .= "</div>";


		$message = $htmlMessage;
		$to = $row['emailaddress'];
		$sentcount = Email::send($to, 'info@smellsurvey.org', $subject, $message);
		// echo "Sent {$sentcount} emails to " . $firstNameTest;

		if ($sentcount) {
			$insertMatchResponse = mysqli_query($con, $insertQuery);
			if ($insertMatchResponse) {
				$errorMessage .= "insert query worked for " . $row['firstname'] . "<br/>";
			} else {
				echo mysqli_error($con);
				$errorMessage .= "insert query did not work for " . $row['firstname'] . "<br/>";
			}
		}
	}

	mysqli_close($con);

	/*	// SEND TEST EMAIL
	 require_once ('include\emailer.php');

	 Email::connect(array('driver' => 'smtp', 'options' => array('hostname' => 'email-smtp.us-east-1.amazonaws.com', 'username' => 'AKIAJ6V5LKGRV6QXOPJQ', //'AKIAIXVU334T5OVFZXVA',
	 'password' => 'Al73kWJRyVst+/FkkN6LxuzhsJO2VM/uTnVyKg/Spl5r', //'ApZ5/l2z8jEKPmBUoT1p1GTNwmsfPdcGmLordtyHZEFq',
	 'encryption' => 'ssl', 'port' => '465', 'timeout' => '')));

	 // loop
	 $firstNameTest = "Claire";

	 $htmlMessage = "<div style='width:550px; margin:0 auto;'>";
	 $htmlMessage .= "<img src='https://www.michaeljfox.org/images/logo-ppmi.jpg' /> ";
	 $htmlMessage .= "<p>Dear " . $firstNameTest . ",</p>";
	 $htmlMessage .= "<p>Thank you for your recent interest in participating in the smell test study which is evaluating the sense of smell and its relationship to neurological disorders such as Parkinson disease. We appreciate the time you have spent completing the background survey.  Based on specific study entry criteria, you are not eligible for participation at this time. </p>";
	 $htmlMessage .= "<p>We will keep your information on file, and we may contact in the future if eligibility requirements change or other projects arise that you may be eligible for. </p>";
	 $htmlMessage .= "<p>Again, we thank you for the time you have spent on this project and greatly appreciate your support of our research. </p>";
	 $htmlMessage .= "<p>Sincerely,<br/>The Smell Test Study Team at IND </p>";
	 $htmlMessage .= "<p>PS- Parkinson’s patients and people without Parkinson’s—family members of patients as well as people who have no relation to someone with Parkinson’s – are needed for research all of the time. To learn more about trials in your area looking for someone like you, visit <a href='http://www.foxtrialfinder.org'>www.foxtrialfinder.org.</a> </p>";

	 $htmlMessage .= "</div>";

	 $subject = !empty($_REQUEST['subject']) ? $_REQUEST['subject'] : 'My Subject';
	 $message = !empty($_REQUEST['message']) ? $_REQUEST['message'] : $htmlMessage;
	 $to = 'cmeunier@michaeljfox.org';
	 $sentcount = Email::send($to, 'info@smellsurvey.org', $subject, $message);
	 echo "Sent {$sentcount} emails";
	 */
	echo $errorMessage;
}

/*
 michaeljfox
 SMTP Username: AKIAIXVU334T5OVFZXVA
 SMTP Password: ApZ5/l2z8jEKPmBUoT1p1GTNwmsfPdcGmLordtyHZEFq
 *
 *
 *
 *
 *
 // send email
 foreach ($Users as $User)
 if (isset($emailaddress)) {
 $emailSubject = 'Your Eligibility for PPMI Has Been Reviewed';
 $mailHeader = "From: ppmi@michaeljfox.org\r\n";
 $mailHeader .= "Reply-To: ppmi@michaeljfox.org\r\n";
 $headers .= "MIME-Version: 1.0\r\n";
 $mailHeader .= "Content-type: text/html; charset=iso-8859-1\r\n";
 $body1 = <div>
 *
 * "Dear ".$firstname.",
 <br/><br/>I am writing to follow up on your recent submission of the smell survey to the Parkinson's Progression Markers Initiative. Your survey responses indicate that you are not eligible to continue in the screening process of the study.
 <br/><br/>While you do not qualify for this study, there are countless other Parkinson's trial opportunities that see both people with the disease, as well as those without the disease. Visit www.foxtrialfinder.org to learn more about trials going on in your area that are looking for someone like you.
 <br/><br/>Thank you for your continued commitment to Parkinson's research.";
 $body2 = "Dear ".$firstname.",
 <br/><br/>I am writing to follow up on your recent submission of the smell survey to the Parkinson's Progression Markers Initiative. Your survey responses indicate that you are eligible to continue in the screening process of the study.
 <br/><br/>You will be receiving a package in the mail containing a smell test in the coming few weeks. Once you receive it, please complete the 20-minute 'scratch and sniff' test and paperwork enclosed and return it to us in the pre-stamped envelope provided. Even if you elect not to complete the test, please return it to us— each test costs $20 and can be put to good use with another candidate.
 <br/><br/>If you have any questions, please be in touch with us at this email.
 <br/><br/>Thank you in advance for the important role you are playing in Parkinson's research.";
 $qualifying = true;
 $zipcodes = array();
 if ($pd_syndrome === 'yes'){
 $qualifying = false;
 }
 if ($ad_dementia === 'yes'){
 $qualifying = false;
 }

 $counter = 0;
 foreach($zipcodes as $var){
 if ($var === $zip_postal_code){
 $counter = 1;
 }
 }
 if ($counter === 0){
 $qualifying = false;
 }

 if (!$qualifying){
 $mail_status = mail($emailaddress, $emailSubject, $body1, $mailHeader) or die ("Failure");
 }
 elseif ($qualifying){
 $mail_status = mail($emailaddress, $emailSubject, $body2, $mailHeader) or die ("Failure");
 }
 else{
 die("Failure");
 }
 } else {
 die("Failure");
 }
 */
?>