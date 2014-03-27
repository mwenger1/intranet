<?php
require_once ('config/config.php');

$formSubmitted = false;

if(count($_POST) > 0){
	$formSubmitted = true;
	include('email.php');

	// echo "form is submitting";

	$submitMessage = "";
	$message = "";

	switch($_POST["hiddenfield"]) {
		case 'vanityURL':
			$submitMessage .= "You're Vanity URL has successfully been submitted and will be available starting this Friday.<br><br>www.michaeljfox.org/<span class='bold'>" . $_POST["vanityAddress"] . "</span> will point to:<br><a href='" . $_POST["vanityPointer"] . "'>" . $_POST["vanityPointer"] . "</a><br><br><span class='bold'>NOTE:</span> Make sure that the URL above points to a working page. If any issues, you can followup with <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a>.";

			$fileName = "submissions/vanityurls.txt";
			$output = "Redirect permanent /". $_POST["vanityAddress"] . " " . $_POST["vanityPointer"]. " #" . $_POST["fromemail"] .  "\n";
			$write2File = file_put_contents (FILEPATH.$fileName,$output,FILE_APPEND | LOCK_EX);
			if ($write2File){
				// echo "wrote to file";
			} else {
				// echo "didnt write to file";
			}

			break;

		case 'addevent':

			$subject = "EVENT: " . $_POST["department"] . ": " . $_POST["eventName"];
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Date: " . $_POST["eventDate"] . "<br><br>";
			$message .= "Start: " . $_POST["eventStartTime"] . "<br><br>";
			$message .= "End: " . $_POST["eventEndTime"] . "<br><br>";
			$message .= "Description: " . $_POST["eventDescription"] . "<br><br>";

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your event (" . $_POST["eventName"] . ")  was successfully submitted and will be added to the calendar in the next few days. You will receive a confirmation email in the next few moments. If you want to followup on this request, reply to the confirmation email.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}


			break;

		case 'bugrequest':
			$subject = "BUG: " . $_POST["department"] . ": " . $_POST["bugname"];
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Priority: " . $_POST["priority"] . "<br><br>";
			$message = "Browser: " . $_POST["bugbrowser"] . "<br><br>";
			$message .= "URL: " . $_POST["bugurl"] . "<br><br>";
			$message .= $_POST["bugdescription"];

			$attachment = false;
			if(file_exists($_FILES["attachment"]["tmp_name"])){
				$attachment = true;
			}

			sendMessage($to,$from,$subject,$message,$attachment);
			if (sendMessage){
				$submitMessage = "Your request was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;


		case 'imagemacro':
			$subject = "MACRO: " . $_POST["department"] . ": " . $_POST["imagetype"] . ": ";
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$otherdimensions = isset($_POST["macrootherdimensions"])?$_POST["macrootherdimensions"]:"";
			$message .= "Priority: " . $_POST["priority"] . "<br><br>";
			$message .= "Other Dimensions: " . $otherdimensions . "<br><br>";
			$message .= "Text: " . $_POST["macrotext"] . "<br><br>";
			$message .= "Due Date: " . $_POST["macroduedate"] . "<br><br>";

			$attachment = false;
			if(file_exists($_FILES["attachment"]["tmp_name"])){
				$attachment = true;
			}

			sendMessage($to,$from,$subject,$message,$attachment);
			if (sendMessage){
				$submitMessage = "Your request to create an image macro was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		case 'editvideo':
			$subject = "EDIT_VIDEO: " . $_POST["department"];
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Link: " . $_POST["videohome"] . "<br><br>";
			$message .= "Instructions: " . $_POST["moreinstructions"] . "<br><br>";
			$message .= "Due Date: " . $_POST["videoduedate"] . "<br><br>";

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your request to edit a video was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		case 'uploadyoutube':
			$subject = "UPLOAD YOUTUBE: " . $_POST["department"];
			$to = "sstartz@michaeljfox.org";
			$from = $_POST["fromemail"];
			$message .= "Link: " . $_POST["videohome"] . "<br><br>";
			$message .= "Title: " . $_POST["videotitle"] . "<br><br>";
			$message .= "Description: " . $_POST["moreinstructions"] . "<br><br>";


			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your request to add a Youtube video was successfully submitted to <a href='mailto:sstartz@michaeljfox.org'>Stephanie</a>. You can followup with her directly on updates and timing.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		case 'staffBioRequest':
			$subject = "STAFF BIO CHANGE: " . $_POST["staff_name"];
			$to = "kbrown@michaeljfox.org";
			$from = $_POST["fromemail"];
			$message .= "Staff Bio: " . $_POST["staff_bio_description"] . "<br><br>";

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your request to edit a staff bio has successfully been submitted to <a href='mailto:kbrown@michaeljfox.org'>Kimberly</a>. You can followup with her directly on updates and timing.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;



		case 'edittext':
			$subject = "EDIT PAGE: " . $_POST["department"];
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Priority: " . $_POST["priority"] . "<br><br>";
			$message .= "URL: " . $_POST["editurl"] . "<br><br>";
			$message .= "Original: " . $_POST["originaltext"] . "<br><br>";
			$message .= "Replacement: " . $_POST["newtext"] . "<br><br>";

			$attachment = false;
			if(file_exists($_FILES["attachment"]["tmp_name"])){
				$attachment = true;
			}

			sendMessage($to,$from,$subject,$message,$attachment);
			if (sendMessage){
				$submitMessage = "Your request to edit text was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;


		case 'addrfa':
			$subject = $_POST["department"] . ": ADD RFA: " . $_POST["rfaName"] . ": ";
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Date: " . $_POST["rfaDate"] . "<br><br>";

			$attachment = false;
			if(file_exists($_FILES["attachment"]["tmp_name"])){
				$attachment = true;
			}

			sendMessage($to,$from,$subject,$message,$attachment);
			if (sendMessage){
				$submitMessage = "Your RFA request was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		case 'sendemail':
			$subject = "EMAIL: " . $_POST["emailName"];
#			$to = array('sbourque@michaeljfox.org', 'mwenger@michaeljfox.org', 'nryerson@michaeljfox.org');
			$to = array('to' => 'sbourque@michaeljfox.org', 'cc' => $_POST["fromemail"], 'bcc' => 'nmarino@michaeljfox.org');
			$from = $_POST["fromemail"];
			$message .= "Department: " . $_POST["department"] . "<br><br>";
			$message .= "Date: " . $_POST["emailDate"] . "<br><br>";
			$message .= "Time: " . $_POST["emailTime"] . "<br><br>";
			$message .= "Template: " . $_POST["emailType"] . "<br><br>";
			$message .= "Audience: " . $_POST["emailAudience"] . "<br><br>";
			$message .= "Supression: " . $_POST["emailSupression"] . "<br><br>";

			$attachment = false;
			if(file_exists($_FILES["attachment"]["tmp_name"])){
				$attachment = true;
			}

			sendMessage($to,$from,$subject,$message,$attachment);
			if (sendMessage){
				$submitMessage = "Your email request was sent to Sue, Nancy and Nico. You should receive an email that includes all of the info for your submission. If you need to update the request or include any photos, reply to that email.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;


		case 'googleAnalytics':
			$subject = "ANALYTICS: Google: " . $_POST["department"] . ": ";
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Priority: " . $_POST["priority"] . "<br><br>";
			$message .= $_POST["analysisdescription"];

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your analytics request was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		case 'otherDescription':
			$subject = "OTHER: " . $_POST["department"] . ": ";
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Priority: " . $_POST["priority"] . "<br><br>";
			$message .= $_POST["otherdescription"];

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your request was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		case 'ftfAnalytics':
			$subject = "ANALYTICS: FTF: " . $_POST["department"] . ": ";
			$to = PRIMARY_EMAIL;
			$from = $_POST["fromemail"];
			$message .= "Priority: " . $_POST["priority"] . "<br><br>";
			$message .= $_POST["analysisdescription"];

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your analytics request was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. (If you do not receive an email, contact <a href='mailto:mwenger@michaeljfox.org'>mwenger@michaeljfox.org</a>.)<br><br> You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		case 'crmAnalytics':
			$subject = "ANALYTICS: CRM: " . $_POST["department"] . ": ";
			$to = "nmarino@michaeljfox.org";
			$from = $_POST["fromemail"];
			$message .= "Name: " . $_POST["crmName"] . "<br><br>";
			$message .= "Purpose: " . $_POST["crmPurpose"] . "<br><br>";
			$message .= "Due Date: " . $_POST["crmDueDate"] . "<br><br>";
			$message .= "Filters: " . $_POST["crmFilters"] . "<br><br>";
			$message .= "Fields Included: " . $_POST["crmFieldsIncluded"] . "<br><br>";
			$message .= "More Info: " . $_POST["analysisdescription"] . "<br><br>";
			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your analytics request was successfully submitted to Nico Marino. He will followup with timing on when it will be ready.";
			} else{
				$submitMessage = "Your request cannot be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;

		default:
			$submitMessage = "Sorry. Your form did not submit. Try again or contact <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to report this problem.";
			break;
	};

	// ADD RETURN BUTTON TO ALL CONFIRMATION FORMS
	$submitMessage.="<br><br><a href='.' class='orangeBtn'>Submit Another Request</a>";




};

?>


<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Digital Strategy Intranet</title>
        <link rel="stylesheet" href="css/form.css">
        <script src="js/vendor/jquery.js"></script>
        <script src="js/form.js"></script>
    </head>
    <body>
	<div class="container">
	<div id="header">
		<img src="https://www.michaeljfox.org/images/mjff-logo.gif" style="width: 200px;" />
    	<h1>Digital Strategy Requests</h1>
    </div>
<?php
	if ($formSubmitted){
?>

	<p><?php echo $submitMessage; ?>

<?php
	}
	else {
?>
    	<p>The Digital Strategy team is here to help you with all of your online needs. To help us fufill your requests even faster, complete the form below.</p>
			<label for="email" name="email">What's your email?</label>
			<input type="email" id="email" name="email" placeholder="*******@michaeljfox.org" class="ml1" autofocus />
			<div id="requestOptions">
				<p>Hi <span id="submitterName" class="bold">Mike</span>! What can the Digital Strategy team do for you today?</p>
				<select name="requestType" id="requestType">
					<option value="">Select</option>
						<optgroup label="Update Website">
							<option value="Blog Post">Add a Blog Post</option>
							<option value="Event on Calendar">Add Event on Calendar</option>
							<option value="New Web Page">Add New Webpage or Functionality</option>
							<option value="Add Rfa">Add RFA</option>
							<option value="Edit bio">Add/Edit Staff Bio page</option>
							<option value="Edit text">Edit Text/Information on a Page</option>
						</optgroup>
						<optgroup label="Analysis & Special Tracking">
							<option value="Vanity URL">Create a Vanity URL</option>
							<option value="Custom Tracking URL">Create Custom Tracking URL</option>
							<option value="CRM Analytics Analysis">Convio/CRM Analysis</option>
							<option value="FTF Analytics Analysis">Fox Trial Finder Analysis</option>
							<option value="Google Analytics Analysis">Google Analytics Analysis</option>
						</optgroup>
						<optgroup label="Outreach">
							<option value="Send out Email">Send out Email</option>
							<option value="Social Posts">Send out Social Posts</option>
						</optgroup>
						<optgroup label="Multimedia">
							<option value="Designed Image">Create Image Macro</option>
							<option value="Edit Video">Edit Video Footage</option>
							<option value="Upload Youtube">Upload Video to Youtube</option>
						</optgroup>
						<optgroup label="Issues & Status">
							<option value="Bug Discovered">Bug Discovered on Website</option>
							<option value="Check on Status">Check on Status of Submitted Request</option>
							<option value="Not Sure">Other</option>
						</optgroup>



				</select>
			</div>
			<div id="requestOptionsError" class="error mt1">
			</div>

<!-- VANITY URL -->
	<div id="vanityURL" class="requestSection">
	 	<p>Note:
			<ul>
				<li>All vanity URLs are added in batches on Fridays. Be sure to schedule appropriately.</li>
				<li>Vanity URLs are case sensitive. Always use lowercase characters when promoting in print.</li>
			</ul>
		</p>
			<form action="" enctype="multipart/form-data" method="post">
			www.michaeljfox.org/<input type="text" name="vanityAddress" id="vanityAddress" placeholder="vanitytext" required /><br/>
			<input type="url" name="vanityPointer" placeholder="Website URL that the vanity link will point to" style="width:391px;" required /><span style="margin-left:1em;">Paste full url & check it</span><br/>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="vanityURL" />
			<input type="submit" value="Add Vanity URL" />

			</form>
	</div>


<!-- BLOG POST -->
	<div id="blogPost" class="requestSection" >
	 	<h3>If you have access to the Content Managment System (CMS):</h3>
			<ol>
				<li><a href="http://50.57.35.97/cms/login.html" target="_blank">Login to the CMS</a> and add your post</a></li>
				<li>Tag the post using the appropriate taxonomy terms.</a></li>
				<li>Use <a href="http://croply.com/" target="_blank">crop.ly</a> to edit image dimensions. NOTE: images should be 636px wide x 339px height.</li>
				<li>Be sure to preview your post on the website by clicking the preview button.</li>
					<ul>
						<li>Make sure all links work.
						</li>
						<li>Make sure image is properly formatted.
						</li>

					</ul>
				</li>
				<li>Email Stephanie when your post has been loaded into the CMS and is ready to be published on the site.
					<ul>
						<li>Include if timing is important. NOTE: Posts are published at roughly 9am, 12pm and 3pm.
						</li>
					</ul>
				</li>
				<li>Helpful Resources:
					<ul>
						<li><a target="_blank" href="https://www.michaeljfox.org/files/10 questions to help you write better headlines _ Poynter.pdf">10 Questions to Write Better Posts</a></li>
						<li><a target="_blank" href="https://www.michaeljfox.org/files/Blog Posting Steps.pdf">Blog Best Practices</a></li>
						<li><a target="_blank" href="https://www.michaeljfox.org/files/The Michael J Fox Foundation Blog - GUIDELINES.pdf">Posting Guidelines</a></li>
						<li><a href="https://www.michaeljfox.org/files/MJFFStyleguideMay2012.pdf" target="_blank">Style Guidelines</a></li>

					</ul>
				</li>

			</ol>
	 	<h3 class="mt2">If you do not have access to the CMS:</h3>
			<ol>
				<li>Email the blogger for your department
					<ul>
						<li>Lauren Anderson (Development)</li>
						<li>Liz Diemer (Team Fox)</li>
						<li>Liz Joyce (Research Partnerships)</li>
						<li>Maggie McGuire (Research & MarComm)</li>
						<li>Stephanie Startz (Digital Strategy)</li>
					</ul>
				</li>
			</ol>

	</div>

<!-- IMAGE -->
	<div id="createImage" class="requestSection" >

		<h3>Creating an Image Macro</h3>
		<p>Image macros are a combination of text and background imagery. The key to image macros is having enough blank space to fit text. Zoomed in images of people's faces is not ideal as there is nowhere to place the text</p>
		<form action="" enctype="multipart/form-data" method="post" >

			<label for="file1">Upload Image for Macro (jpg, png, gif):</label>
			<input type="file" name="attachment" id="file1"> <br>
			<br>
			<select name="imagetype" class="mb1" required>
				<option>Select purpose</option>
				<option value="blog">Blog (636px x 339px)</option>
				<option value="facebook">Facebook (800px x 800px)</option>
				<option value="instagram">Instagram (800px x 800px)</option>
				<option value="homepage">Homepage Banner (1000px x 280px)</option>
				<option value="other">Other</option>
			</select>
			<br>
			<div style="display:none;" id="hiddenMacroDimensions">

				<input type="text" placeholder="What dimensions are you looking for" style="width:400px;" class="mb1" name="macrootherdimensions" /><br>
			</div>





			<input type="text" placeholder="Text to go over macro. Keep it short!" style="width:400px;" class="mb1" name="macrotext" required />
			<br>

			<select name="priority" class="mb1" required>
				<option>Choose a Priority</option>
				<option value="Medium">Medium - Work on in a timely manner (~ 1 week: First come first serve).</option>
				<option value="Minor">Low - Complete when time is available (First come first serve)</option>
			</select>
			<br>
			<input type="text" placeholder="Due date" style="width:400px;" class="mb1" name="macroduedate"  />
			<br>

			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="imagemacro" />
			<input type="submit" value="Submit Your Macro" />
		</form>

	</div>

<!-- EDIT VIDEO FOOTAGE -->
	<div id="editVideo" class="requestSection" >

		<h3>Edit Video Footage</h3>
		<p><a href="mailto:hoppenheimer@michaeljfox.org">Hannah</a> will be editing your video for you. Submit your request by filling in the form below.</p>
		<form action="" enctype="multipart/form-data" method="post" >

			<input type="text" placeholder="Shared drive link or drop box link" style="width:400px;" class="mb1" name="videohome" required />
			<br>
			<input type="text" placeholder="Due date (optional)" style="width:400px;" class="mb1" name="videoduedate"  />
			<br>
			<textarea name="moreinstructions" cols="80" rows="8" placeholder="Are there any instructions for the editing? (optional)" ></textarea>

			<br>
			<label>Attachments:</label><p>If there are any images you would like to include in the video, submit this form, and then reply to the confirmation email with those attachments.</p>
			<br>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="editvideo" />
			<input type="submit" value="Submit Request" />
		</form>

	</div>

<!-- UPLOAD TO YOUTUBE -->
	<div id="uploadYoutube" class="requestSection" >

		<h3>Upload Video to Youtube</h3>
		<p><a href="mailto:sstartz@michaeljfox.org">Stephanie Startz</a> will be uploading your video for you. Submit your request by filling in the form below.</p>
		<form action="" enctype="multipart/form-data" method="post" >

			<input type="text" placeholder="Shared drive link or drop box link" style="width:400px;" class="mb1" name="videohome" required />
			<br>
			<input type="text" placeholder="Video Title" style="width:400px;" class="mb1" name="videotitle" required />
			<br>
			<textarea name="moreinstructions" cols="80" rows="8" placeholder="Short description to appear next to video" ></textarea>
			<br>

			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="uploadyoutube" />
			<input type="submit" value="Submit Your Video" />
		</form>

	</div>

<!-- RFA UPLOAD -->
	<div id="addRfa" class="requestSection">
		<p>When adding a new RFA to the website, you can use this form to upload the initial word document with all of your content. Once you submit the form and want to make additional changes, make sure to use track changes in Word and then reply to your Fogbugz email with the new attachment.</p>
		<p>NOTE: If there are changes on multiple pages, fill in the form for each page where there is a change.</p>

		<form action="" enctype="multipart/form-data" method="post" >

			<input type="text" placeholder="Name of RFA" style="width:400px;" class="mb1" name="rfaName" required />
			<br>

				<label>Launch Date:</label>
				<input style="margin-right:10px;"type="date" placeholder="Date" name="rfaDate" required />
				<span style="font-style:italic; font-size: 0.8em;">To ensure enough time, submit the initial request 2 weeks prior</span>
				<br>

			<br>
			<label for="file1">Upload Word Document:</label>
			<input type="file" name="attachment" id="rfaFile1"> <span>&nbsp;(doc, docx)<br>
			<br>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="addrfa" />
			<input type="submit" value="Submit Your RFA" />
		</form>


	</div>





<!-- EDIT TEXT -->
	<div id="editText" class="requestSection">
		<p>Whether there is a typo, a stat needs to be updated, or you want to reword something, fill in the form below.</p>
		<p>NOTE: If there are changes on multiple pages, fill in the form for each page where there is a change.</p>

		<form action="" enctype="multipart/form-data" method="post" >

			<input type="url" placeholder="Website URL that needs to be updated" style="width:400px;" class="mb1" name="editurl" required />
			<br>

			<select name="priority" class="mb1" required>
				<option>Choose a Priority</option>
				<option value="Urgent">Urgent - Affects all users. Stop everything to fix.</option>
				<option value="Major">High - Affects Majority of Users. Complete ASAP.</option>
				<option value="Medium">Medium - Work on in a timely manner (~ 1 week: First come first serve).</option>
				<option value="Minor">Low - Complete when time is available (First come first serve)</option>
			</select>
			<br>

			<textarea name="originaltext" cols="80" rows="8" placeholder="Copy and paste the original text." required ></textarea>

			<br>

			<textarea name="newtext" cols="80" rows="8" placeholder="Paste the new text that will take its place." required ></textarea>

			<br>
			<label for="file1">Upload File (optional):</label>
			<input type="file" name="attachment" id="file1"> <span>&nbsp;(jpg, png, doc, docx, pdf, xls, ppt)<br>
			<br>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="edittext" />
			<input type="submit" value="Submit Your Text Edit" />
		</form>


	</div>

<!-- GOOGLE ANALYTICS -->
	<div id="googleAnalytics" class="requestSection">
	 	<p>Note:
			<ul>
				<li>All Google Analytics analysis is generally scheduled for Fridays. You can expect to hear back from <a href="mailto:mwenger@michaeljfox.org">Mike Wenger</a> by end of day Friday.</li>
				<li>Give as much details as possible the first time around in terms of what you are hoping to learn. That way we can get the specific information to you right away.</li>
				<li>What segment are you looking to analyze? (traffic from a custom url? visitors to a specific page?)</li>
				<li>What conversions are important to look at (donations, email signups)?</li>
				<li>What timeline are you looking to analyze (past week, this month compared to the same time last year)?</li>
				<li>If this is information you will want on a regular basis (weekly, monthly), let us know so we can set up a custom report that automatically gets emailed to you.</li>
			</ul>
		</p>
			<form action="" enctype="multipart/form-data" method="post">
			What are you trying to gain insight into?<br>
			<textarea name="analysisdescription" cols="70" rows="20" placeholder="Be sure to give as much information as possible" required></textarea>
						<br>

			<select name="priority" class="mb1" required>
				<option>Choose a Priority</option>
				<option value="Major">High - Need right away. Complete ASAP.</option>
				<option value="Medium">Medium - Work on in a timely manner (~ 1 week: First come first serve).</option>
				<option value="Minor">Low - Complete when time is available (First come first serve)</option>
			</select>
			<br>

			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="googleAnalytics" />
			<input type="submit" value="Request Analysis" />

			</form>
	</div>

<!-- FTF ANALYTICS -->
	<div id="ftfAnalytics" class="requestSection">
	 	<p>Note:
			<ul>
				<li>Fox Trial Finder Analytics analysis is generally scheduled for Fridays. You can expect to hear back from <a href="mailto:mwenger@michaeljfox.org">Mike Wenger</a> by end of day Friday.</li>
				<li>Give as much details as possible the first time around in terms of what you are hoping to learn. That way we can get the specific information to you right away.</li>
				<li>What segment are you looking to analyze? (traffic from a custom url? visitors to a specific page?)</li>
				<li>What conversions are important to look at (donations, email signups)?</li>
				<li>What timeline are you looking to analyze (past week, this month compared to the same time last year)?</li>
			</ul>
		</p>
			<form action="" enctype="multipart/form-data" method="post">
			What are you trying to gain insight into?<br>
			<textarea name="analysisdescription" cols="70" rows="20" placeholder="Be sure to give as much information as possible" required ></textarea>
			<br>
			<select name="priority" class="mb1" required>
				<option>Choose a Priority</option>
				<option value="Major">High - Need right away. Complete ASAP.</option>
				<option value="Medium">Medium - Work on in a timely manner (~ 1 week: First come first serve).</option>
				<option value="Minor">Low - Complete when time is available (First come first serve)</option>
			</select>
			<br>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="ftfAnalytics" />
			<input type="submit" value="Request Analysis" />

			</form>
	</div>

<!-- CRM ANALYTICS -->
	<div id="crmAnalytics" class="requestSection">
		<p>CRM analytics is conducted by <a href="mailto:nmarino@michaeljfox.org">Nico Marino</a>.</p>
		<p>When you submit your request, Nico will respond with timing (based on other requests in the queue, and how intensive the report is to pull).</p>
			<ul>

				<li>Give as much details as possible the first time around in terms of what you are hoping to learn. That way we can get the specific information to you right away.</li>
				<li>What segment are you looking to analyze? (traffic from a custom url? visitors to a specific page?)</li>
				<li>What conversions are important to look at (donations, email signups)?</li>
				<li>What timeline are you looking to analyze (past week, this month compared to the same time last year)?</li>
			</ul>
			<form action="" enctype="multipart/form-data" method="post">
			<input type="text" name="crmName" value="" placeholder="List/Analysis Name" required /> <br>
			<input type="text" name="crmPurpose" value="" placeholder="Purpose" required /> <br>
			<input type="text" name="crmDueDate" value="" placeholder="Preferred Due Date" required /> <br>
			<input type="text" name="crmFilters" value="" placeholder="Filters" required /> <br>
			<input type="text" name="crmFieldsIncluded" value="" placeholder="Fields to be Included" required /> <br>
			<textarea name="analysisdescription" cols="70" rows="20" placeholder="Additional information" required ></textarea>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="crmAnalytics" />
			<input type="submit" value="Request Analysis" />

			</form>
	</div>


<!-- SOCIAL POSTS -->
	<div id="socialPosts" class="requestSection">
		<p>All social posts on Twitter, Facebook and Google Plus are managed by Stephanie Startz. <a href="mailto:sstartz@michaeljfox.org?subject=Social Post Request">Email Stephanie</a> to promote your content.</p>
		<p>Things to include in your email:
			<ul>
				<li>What is the goal of the post (i.e. drive awareness, clinical trial signups, team fox event)</li>
				<li>Does the post need an image (include as image if available)?</li>
				<li>What is the timing for the posts? To best plan out the social calendar, it is helpful to notify Stephanie 2 weeks to 1 month in advance.</li>
				<li>Should the posts be geotargeted? To what location?</li>
			</ul>
	</div>

<!-- CALENDAR REQUEST -->
	<div id="calendarRequest" class="requestSection" >
	 	<h3>If you have access to the Content Managment System (CMS):</h3>
			<ul>
				<li><a href="http://50.57.35.97/cms/login.html" target="_blank">Login to the CMS</a> and follow these <a href="http://50.57.35.97/files/WebsiteEvents_development.pdf" target="_blank">Step by Step Instructions</a></li>
				<li>Remember, the sooner you add your event to the calendar, the earlier people will know about it.</li>
				<li>If your event requires a registration form, contact <a href="mailto:hoppenheimer@michaeljfox.org">Hannah Oppenheimer</a>.</li>
			</ul>

	 	<h3 class="mt2">If you do not have access to the CMS:</h3>
			<ul>
				<li>To add your event, fill in the form below.</li>
			</ul>
			<form action="" enctype="multipart/form-data" method="post" >
				<input type="text" name="eventName" placeholder="Event Name" class="mt1" required /><br>
				<label>Date:</label>
				<input type="date" placeholder="Date" name="eventDate" required /><br>
				<label for="startTime">Start Time</label>
				<input type="time" id="startTime" class="mt1" name="eventStartTime" required />
				<label for="endTime">End Time</label>
				<input type="time" id="endTime" class="mt1" name="eventEndTime" />
				<br>
				<textarea placeholder="Event Description" cols="70" rows="20" class="mt1" name="eventDescription" required ></textarea>
				<br>
<!-- 				<label>Logo or Image</label><input type="file" />
				<br>	-->
				<input type="hidden" name="fromemail" value="" />
				<input type="hidden" name="department" value="" />
				<input type="hidden" name="hiddenfield" value="addevent" />
				<input type="submit" value="Add Your Event" />
			</form>
	</div>


<!-- NEW PAGE REQUEST -->
	<div id="newPageRequest" class="requestSection">
		<p>To add a new webpage or functionality, it's best to understand 3 questions:</p>
		<h3>Who? What? Why?</h3>
		<p>"User stories" offer a really helpful way to articulate this and some recent examples are:</p>
			<ul style="font-size:0.9em;">
				<li>As a PD Researcher, I want to be able to register for the PD Therapeutics conference so that I can learn the latest research and network with other scientists</li>
				<li>As a visitor to the Team Fox website, I want to be able to see a real time counter of the top fundraisers so that I can see if I am eligible for MVP dinner</li>
				<li>As a PD patient visiting the blog, I want to be able to read and print food recipes so that I can improve my diet</li>

			</ul>
		<p>Use the form below to submit your "user story." Once submitted, it will go into the Digital Strategy's work backlog. Your department champion (<span class="deptChampion"></span>) will work collaboratively with other department champions and Sean Keating to prioritize the work. Follow up with <span class="deptChampion"></span> to check in on timing for completion.</p>

		<p>As a <input type="text" placeholder="PD Researcher" name="staff_name" style="margin-left:5px; width: 150px;"/> I want <input type="text" name="staff_name" placeholder="to be able to register for the PD Therapeutics conference" style="margin-left:5px; width: 380px;" /><br>
		so that <input type="text" name="staff_name" placeholder="I can learn the latest research and network with other scientists" style="margin-left:5px; width:460px;" />.</p>
		<textarea name="otherdescription" cols="70" rows="6" placeholder="Provide any additional information about why this is important for the foundation, or how you would like it to be implemented." required></textarea><br>

		<input type="hidden" name="fromemail" value="" />
		<input type="hidden" name="department" value="" />
		<input type="hidden" name="hiddenfield" value="newPageRequest" />
		<input type="submit" value="Submit" />

	</div>

<!-- OTHER REQUEST -->
	<div id="otherRequest" class="requestSection">
		<p>Can't figure out which option to select from the drop down above. Submit the form below with as much detail as possible and we will get back to you with timing.</p>
			<form action="" enctype="multipart/form-data" method="post">
			What do you need help with?<br>
			<textarea name="otherdescription" cols="70" rows="20" placeholder="Be sure to give as much information as possible" required></textarea><br>
			<br>
			<select name="priority" class="mb1" required>
				<option>Choose a Priority</option>
				<option value="Urgent">Urgent - Affects all users. Stop everything to fix.</option>
				<option value="Major">High - Affects Majority of Users. Complete ASAP.</option>
				<option value="Medium">Medium - Work on in a timely manner (~ 1 week: First come first serve).</option>
				<option value="Minor">Low - Complete when time is available (First come first serve)</option>
			</select>
			<br>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="otherDescription" />
			<input type="submit" value="Submit" />

			</form>


	</div>

<!-- EDIT STAFF BIO -->
	<div id="staffBioRequest" class="requestSection">
		<p>Have a new staff member or want to edit an existing bio on the website? See <a href="https://www.michaeljfox.org/foundation/leaders.html" target="_blank">leadership and staff page</a> for reference.</p>
			<form action="" enctype="multipart/form-data" method="post">
			Name: <input type="text" name="staff_name" />
			<textarea name="staff_bio_description" cols="70" rows="20" placeholder="Staff bio." required></textarea><br>
			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="staffBioRequest" />
			<input type="submit" value="Submit" />

			</form>


	</div>

<!-- BUG REQUEST -->
	<div id="bugRequest" class="requestSection">
		<p>Bugs happen and thanks for your help in finding one. Fill in the form below so we can start working on the fix.</p>
		<form action="" enctype="multipart/form-data" method="post" >

			<input type="text" placeholder="Briefly Describe the Bug" style="width:400px;" class="mb1" name="bugname" required />
			<br>

			<select name="priority" class="mb1" required>
				<option>Choose a Priority</option>
				<option value="Urgent">Urgent - Affects all users. Stop everything to fix.</option>
				<option value="Major">High - Affects Majority of Users. Complete ASAP.</option>
				<option value="Medium">Medium - Work on in a timely manner (~ 1 week: First come first serve).</option>
				<option value="Minor">Low - Complete when time is available (First come first serve)</option>
			</select>
			<br>

			<input type="url" name="bugurl" placeholder="Website URL for where the bug was discovered" style="width:400px;" class="mb1" required />
			<br>
			<select name="bugbrowser" class="mb1" required>
				<option>Browser Used</option>
					<optgroup label="Internet Explorer">
						<option value="ie10">Internet Explorer 10</option>
						<option value="ie9">Internet Explorer 9</option>
						<option value="ie8">Internet Explorer 8</option>
						<option value="ie7">Internet Explorer 7</option>
					</optgroup>
					<optgroup label="Modern Browsers">
						<option value="chrome">Chrome</option>
						<option value="opera">Opera</option>
						<option value="firefox">Firefox</option>
						<option value="safari">Safari</option>
					</optgroup>
					<optgroup label="Mobile/Tablet">
						<option value="iphone5">iphone5</option>
						<option value="iphone4">iphone4</option>
						<option value="windowsphone">iPad</option>
						<option value="android">Android</option>
						<option value="androidtablet">Android Tablet</option>
						<option value="androidtablet">Android Tablet</option>
						<option value="blackberry">Blackberry</option>
						<option value="windowsphone">Windows Phone</option>

					</optgroup>

			</select>
			<br>
			<textarea name="bugdescription" cols="80" rows="15" placeholder="Provide step by step details of how to recreate the bug." required ></textarea>
			<br>
			<label for="file2">Upload Screenshot of Issue (optional):</label>
			<input type="file" name="attachment" id="file2"> <span>&nbsp;(jpg, png, doc, docx, pdf, xls)<br>
			<br>

			<input type="hidden" name="fromemail" value="" />
			<input type="hidden" name="department" value="" />
			<input type="hidden" name="hiddenfield" value="bugrequest" />
			<input type="submit" value="Submit Your Bug" />
		</form>
		<!-- <p>Email <a href="mailto:cases@michaeljfox.fogbugz.com">cases@michaeljfox.fogbugz.com</a> to report the issue. In your email, be sure to:
			<ul>
				<li>Succinctly explain the problem in the subject line along with how critical the issue is.</li>
					<ul>
						<li>If it is a major issue affecting many users: (ex - <span class="italics">Priority 1 Bug: Major Typo on Homepage</span>)</li>
						<li>If it is a medium issue: (ex - <span class="italics">Priority 2 Bug: Link in Blog Post Not Working</span>)</li>
						<li>If it is a minor issue: (ex - <span class="italics">Priority 3 Bug: Image Formatting Needs Slight Adjustment</span>)</li>
					</ul>
				<li>Include the URL where you found the bug. If it is a multi-step process (i.e. registering for Team Fox), include detailed steps so we can recreate the issue.</li>
				<li>If you think it may help us understand the issue, you can <a href="http://www.take-a-screenshot.org/" target="_blank">take a screenshot</a> of the problem and include as an attachment in your email.</li>
				<li>Include what browser are you using. (i.e - Internet Explorer 8, Google Chrome, Safari browser on iPhone5)
			</ul>
		</p> -->
	</div>

<!-- CHECK ON CASE -->
	<div id="fogbugzRequest" class="requestSection">
		<p>The Digital Strategy team uses <a href="https://michaeljfox.fogbugz.com/default.asp">Fogbugz</a> to track and prioritize all work coming in from all of the teams at the Foundation. Requests are called cases. When one of your cases is completed, you will automatically be notified by email.</p>
		<p>If you want to check on the status of an open case, click on the link that was in the automated email response from cases@michaeljfox.fogbugz.com OR if you know your case ID number, you can fill it in on <a href="https://michaeljfox.fogbugz.com/default.asp?pg=pgPublicViewForm" target="_blank">Fogbugz</a>.</p>
		<p>If you want to see how your case is prioritized relative to other requests coming from your department, email <a href="mailto:mwenger@michaeljfox.org">Mike Wenger</a>.</p>
	</div>




<!-- CUSTOM TRACKING URL -->
	<div id="customTrackingRequest" class="requestSection">
		<p>Steps
			<ol>
				<li>Open the <a href="https://docs.google.com/spreadsheet/ccc?key=0AqfOPE4JePo1dEdDbGREdTJDQ3MzR05TZGI0WGRuWkE#gid=0" target="_blank">Custom Tracking Google Doc</a>.</li>
				<li>Scroll to the bottom of the excel and add your information in the last row.
				<li>Important things to note
					<ul>
						<li>Don't use a vanity url. Only use original website url.</li>
						<li>Make sure to select the preset options in the spreadsheet.</li>
						<li>Always test your new url in a browser to make sure it works.</li>
					</ul>
				</li>
			</ol>
		</p>


	</div>

<!-- SEND OUT EMAIL -->
	<div id="emailRequest" class="requestSection">
		<h3>Sending Out an Email</h3>
		<p>Steps:</p>
		<ol>
			<li>Add email to the MJFF Email Calendar in Outlook one week prior to delivery.</li>
			<li>Fill in form below 2 days prior to your email being sent. You can always make changes post submission (i.e. you need to provide a blog post link).</li>
		</ol>

			<form action="" enctype="multipart/form-data" method="post" >
				<input type="text" name="emailName" placeholder="Subject Line of Email" class="mt1" required /><br><br>
				<label>Date Email is Going Out:</label>
				<input type="date" placeholder="Date" name="emailDate" required /><br><br>
				<label for="emailTime">Time Email is Going Out:</label>
					<select name="emailTime">
						<option>Select</option>
						<option value="morning">Morning</option>
						<option value="midday">Midday</option>
						<option value="afternoon">Afternoon</option>
					</select>

				<br><br>
				<label for="emailType">Email Type: </label>
					<select name="emailType" id="emailType">
						<option>Select</option>
						<option val="CT_Fair_Invite">CT_Fair_Invite</option>
						<option val="Fox_Flash">Fox_Flash</option>
						<option val="Hot_Topics">Hot_Topics</option>
						<option val="Research_Roundtable">Research_Roundtable</option>
						<option val="TeamFox_Text_Only">TeamFox_Text_Only</option>
						<option val="TeamFox_Text_with_Bullets">TeamFox_Text_with_Bullets</option>
						<option val="Text_Only">Text_Only</option>
						<option val="Text_with_Bullets">Text_with_Bullets</option>
						<option val="Text_with_Image_Caption_and_Button">Text_with_Image_Caption_and_Button</option>
						<option val="Text_with_Image_LEFT_Square">Text_with_Image_LEFT_Square</option>
						<option val="Text_with_Image_RIGHT_Square">Text_with_Image_RIGHT_Square</option>
						<option val="Text_with_Signature">Text_with_Signature</option>
						<option val="Text_with_Video">Text_with_Video</option>
						<option val="ThinkAble">ThinkAble</option>
						<option val="eNewsletter">eNewsletter</option>
					</select>
					<span>(You can view all templates <a href="https://github.com/Michael-J-Fox-Foundation/email_templates" target="_blank">here</a>)</span>

				<br><br>
				<input type="text" placeholder="Email Audience" name="emailAudience" required /><br><br>
				<input type="text" placeholder="Supression List" name="emailSupression" required /><br><br>

				<label for="file1">Upload Email Copy In Word Document:</label>
				<input type="file" name="attachment" id="emailFile1"> &nbsp;(doc, docx)
				<br><span style="font-style:italic; font-size: 0.8em;">If you have images, submit form and you will receive an autoemail. Reply to that email with photo attachments.</span>
				<br>

<!-- 				<label>Logo or Image</label><input type="file" />
				<br>	-->
				<input type="hidden" name="fromemail" value="" />
				<input type="hidden" name="department" value="" />
				<input type="hidden" name="hiddenfield" value="sendemail" />
				<input type="submit" value="Submit Your Email Request" />
			</form>
	</div>



	</div>


<?php
}
?>
</div>
<div class="footer">
</div>
    </body>
</html>
