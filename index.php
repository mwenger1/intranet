<?php
$formSubmitted = false;

if(count($_POST) > 0){
	$formSubmitted = true;
	include('email.php');

	// echo "form is submitting";
	$filePath = "/home/mikewenger/mbwenger.com/digital_strategy_form/submissions/";
	$submitMessage = "";
	

	switch($_POST["hiddenfield"]) {
		case 'vanityURL':
			$submitMessage .= "You're Vanity URL has successfully been submitted and will be available starting this Friday.<br><br>www.michaeljfox.org/<span class='bold'>" . $_POST["vanityAddress"] . "</span> will point to:<br><a href='" . $_POST["vanityPointer"] . "'>" . $_POST["vanityPointer"] . "</a><br><br><span class='bold'>NOTE:</span> Make sure that the URL above points to a working page. If any issues, you can followup with <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a>.";

			$fileName = "vanityurls.txt";
			$output = "Redirect permanent /". $_POST["vanityAddress"] . " " . $_POST["vanityPointer"]. "\n";
			$write2File = file_put_contents ($filePath.$fileName,$output,FILE_APPEND | LOCK_EX);
			if ($write2File){
				// echo "wrote to file";
			} else {
				// echo "didnt write to file";
			}
			
			break;

		case 'addevent':

			$subject = "Event: " . $_POST["eventName"];
			$to = "cases@michaeljfox.fogbugz.com";
			$from = $_POST["fromemail"];			
			$message .= "Date: " . $_POST["eventDate"] . "<br>";
			$message .= "Start: " . $_POST["eventStartTime"] . "<br>";
			$message .= "End: " . $_POST["eventEndTime"] . "<br>";
			$message .= "Description: " . $_POST["eventDescription"] . "<br>";

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your event (" . $_POST["eventName"] . ")  was successfully submitted and will be added to the calendar in the next few days. You will receive a confirmation email in the next few moments. If you want to followup on this request, reply to the confirmation email.";
			} else{
				$submitMessage = "Your request can not be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}

			
			break;

		case 'bugrequest':
			$subject = "Bug: " . $_POST["priority"] . ": " . $_POST["bugname"];
			$to = "cases@michaeljfox.fogbugz.com";
			$from = $_POST["fromemail"];
			$message = "Browser: " . $_POST["bugbrowser"] . "<br>";
			$message .= "URL: " . $_POST["bugurl"] . "<br>";
			$message .= $_POST["bugdescription"];
			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your request was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request can not be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
			}
			break;


		case 'edittext':
			$subject = "Edit: " . $_POST["priority"] . ": ";
			$to = "cases@michaeljfox.fogbugz.com";
			$from = $_POST["fromemail"];
			$message .= "URL: " . $_POST["editurl"] . "<br>";
			$message .= "Original: " . $_POST["originaltext"] . "<br>";
			$message .= "Replacement: " . $_POST["newtext"] . "<br>";

			sendMessage($to,$from,$subject,$message);
			if (sendMessage){
				$submitMessage = "Your request to edit text was successfully submitted. You should receive a confirmation email to your inbox that contains the Fogbugz tracking number for future reference. You will get an email once the issue is resolved.";
			} else{
				$submitMessage = "Your request can not be processed at this time. Email <a href='mailto:mwenger@michaeljfox.org'>Mike Wenger</a> to notify him of this issue.";
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
        <title>Digital Strategy Forms</title>
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
							<option value="New Web Page">Add New Web Page</option>
							<option value="Designed Image">Create Designed Image (ex: Fox Foto Friday)</option>
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
			<form action="" method="post">
			www.michaeljfox.org/<input type="text" name="vanityAddress" id="vanityAddress" placeholder="vanitytext" required /><br/>
			<input type="url" name="vanityPointer" placeholder="Website URL that the vanity link will point to" style="width:391px;" required /><span style="margin-left:1em;">Paste full url & check it</span><br/>
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
				<li>Helpful Resources: <a href="#">Blog Best Practices</a> and <a href="https://www.michaeljfox.org/files/MJFFStyleguideMay2012.pdf" target="_blank">Style Guidelines</a></li>

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
				<li>Helpful Resources: <a href="#">Blog Best Practices</a></li>
			</ol>
		
	</div>

<!-- IMAGE -->
	<div id="createImage" class="requestSection" >
	 	<p>To create a custom image, email <a href="mailto:hoppenheimer@michaeljfox.org">Hannah Oppenheimer</a> with as much information as possible.</p>
	 	<p>Things to think about and include:
			<ol>
				<li>Do you already have an image that can be used and modified? (attache these to your email)</li>
				<li>What are the dimensions of the images?</li>
				<li>Where will the image be used?</li>
				<li>Do you already have an image that can be used and modified?</li>
				<li>When do you need the image by? NOTE: Images are time intensive. Try to give at least 3 days notice</li>

			</ol>
		</p>
		<p><span style="font-weight:bold; font-style-italic;">NOTE: <span style="text-transform:lowercase;">COMING SOON, THIS WORKFLOW WILL BE REPLACED BY AN ONLINE FORM ON THIS PAGE</span></span>
		<p>
	</div>


<!-- EDIT TEXT -->
	<div id="editText" class="requestSection">
		<p>Whether there is a typo, a stat needs to be updated, or you want to reword something, fill in the form below.</p>
		<p>NOTE: If there are changes on multiple pages, fill in the form for each page where there is a change.</p>

		<form action="" method="post" >
			
			<input type="url" placeholder="Website URL that needs to be updated" style="width:400px;" class="mb1" name="editurl"/>
			<br>

			<select name="priority" class="mb1">
				<option>Choose a Priority</option>
				<option value="Major">Time Sensitive - Needs to update as soon as possible.</option>
				<option value="Minor">Not Critical - Update when there is time.</option>
			</select>
			<br>

			<textarea name="originaltext" cols="80" rows="8" placeholder="Copy and paste the original text."></textarea>

			<br>

			<textarea name="newtext" cols="80" rows="8" placeholder="Paste the new text that will take its place."></textarea>

			<br>
			<input type="hidden" name="fromemail" value="" />
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
			<form action="" method="post">
			What are you trying to gain insight into?<br>
			<textarea cols="70" rows="20" required placeholder="Be sure to give as much information as possible"></textarea>
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
			<form action="" method="post">
			What are you trying to gain insight into?<br>
			<textarea cols="70" rows="20" required placeholder="Be sure to give as much information as possible"></textarea>
			<input type="hidden" name="hiddenfield" value="googleAnalytics" /> 
			<input type="submit" value="Request Analysis" />

			</form>
	</div>

<!-- CRM ANALYTICS -->
	<div id="crmAnalytics" class="requestSection">
		<p>CRM analytics is conducted by <a href="mailto:nmarino@michaeljfox.org">Nico Marino</a>.</p>
		<p>When you submit your request, Nico will respond with timing (based on other requests in the queue, and how intensive the report is to pull).</p>

	 	<p>Things to think about:
			<ul>

				<li>Give as much details as possible the first time around in terms of what you are hoping to learn. That way we can get the specific information to you right away.</li>
				<li>What segment are you looking to analyze? (traffic from a custom url? visitors to a specific page?)</li>
				<li>What conversions are important to look at (donations, email signups)?</li>
				<li>What timeline are you looking to analyze (past week, this month compared to the same time last year)?</li>
			</ul>
		</p>
			<form action="" method="post">
			What are you trying to gain insight into?<br>
			<textarea cols="70" rows="20" required placeholder="Be sure to give as much information as possible"></textarea>
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
			<form action="" method="post" >
				<input type="text" name="eventName" placeholder="Event Name" class="mt1" required/><br>
				<label>Date:</label>
				<input type="date" placeholder="Date" name="eventDate" required /><br>
				<label for="startTime">Start Time</label>
				<input type="time" id="startTime" class="mt1" name="eventStartTime" required/>
				<label for="endTime">End Time</label>
				<input type="time" id="endTime" class="mt1" name="eventEndTime" />
				<br>
				<textarea placeholder="Event Description" cols="70" rows="20" class="mt1" name="eventDescription" required></textarea>
				<br>
<!-- 				<label>Logo or Image</label><input type="file" />
				<br>	-->
				<input type="hidden" name="fromemail" value="" />
				<input type="hidden" name="hiddenfield" value="addevent" />
				<input type="submit" value="Add Your Event" /> 
			</form>
	</div>


<!-- NEW PAGE REQUEST -->
	<div id="newPageRequest" class="requestSection">
		<p>To create a new page for the website, set up a half-hour meeting with Hannah Oppenheimer and Michael Wenger.</p>
		<p>Some things to think about before the meeting:
			<ul>
				<li>It takes 3-5 days to put together a single landing page. 1-2 weeks to create several pages (or a mini-site). Schedule appropriately.</li>
				<li>What is the content for the page? If you have content ready, you can save it in a word document.</li>
				<li>Does the page need images or logos? Do you have them already or do you need the Digital Strategy to help you put them together.</li>
				<li>What page template will work best?
					<ul>
						<li><a href="https://www.michaeljfox.org/page.html?ppmi-smell" target="_blank" >Standard Template (w/ Callouts)</a> - <span class="italics">Less Time Intensive</span></li>
						<li><a href="https://www.michaeljfox.org/page.html?Summer-Series-Lemonade" target="_blank" >Standard Template (w/o Callouts)</a> - <span class="italics">Less Time Intensive</span></li>
						<li><a href="http://www.michaeljfox.org/thinkableLanding/thinkable.html" target="_blank" >Customized Template</a> - <span class="italics">More Time Intensive</span></li>

					</ul>
				</li>
				<li>How does this page fit within the site navigation? NOTE: not all pages can be available from the navigation due to limited real estate.</li>
				<li>How will you promote this new page? (social, email blast)</li>
			</ul>
		</p>
	</div>

<!-- OTHER REQUEST -->
	<div id="otherRequest" class="requestSection">
		<p>Can't figure out which option to select from the drop down above. Email <a href="mailto:mwenger@michaeljfox.org">Mike Wenger</a> with the details of what you are looking for.</p>
	</div>

<!-- BUG REQUEST -->
	<div id="bugRequest" class="requestSection">
		<p>Bugs happen and thanks for your help in finding one. Fill in the form below so we can start working on the fix.</p>
		<form action="" method="post" >
			
			<input type="text" placeholder="Briefly Describe the Bug" style="width:400px;" class="mb1" name="bugname"/>
			<br>

			<select name="priority" class="mb1">
				<option>Choose a Priority</option>
				<option value="Major">Critical - Affects Majority of Users. Functionality not working.</option>
				<option value="Medium">Medium - Affects Some Users. Fix When We Can.</option>
				<option value="Minor">Minor - Less Important. Get to when there's time.</option>
			</select>
			<br>

			<input type="url" name="bugurl" placeholder="Website URL for where the bug was discovered" style="width:400px;" class="mb1"/>
			<br>
			<select name="bugbrowser" class="mb1">
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
			<textarea name="bugdescription" cols="80" rows="15" placeholder="Provide step by step details of how to recreate the bug."></textarea>

			<input type="hidden" name="fromemail" value="" />
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
		<p>If you want to see how your case is prioritized relative to other requests coming from your department, click on your department below: <span style="font-weight:bold; font-style-italic;">NOTE: THIS FEATURE IS COMING SOON</span>
			<li><a href="#">Administration</a></li>
			<li><a href="#">Development</a></li>
			<li><a href="#">MarComm</a></li>
			<li><a href="#">Research Props</a></li>
			<li><a href="#">Research Partnerships</a></li>
			<li><a href="#">Research Partnerships</a></li>
			<li><a href="#">Team Fox</a></li>

		</p>
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
<!-- 			<select name="trackingSource" id="trackingSource">
				<option>Source</option>
				<option value="cpc">cpc</option>
				<option value="cpm">cpm</option>
				<option value="display_ad">display_ad</option>
				<option value="email">email</option>
				<option value="link">link</option>
				<option value="press_release">press_release</option>
				<option value="qrcode">qrcode</option>
				<option value="signature">signature</option>
				<option value="social">social</option>
				<option value="tfsocial">tfsocial</option>
				<option value="website">website</option>
			</select>

			<select name="trackingMedium" id="trackingMedium">
				<option>Medium</option>
				<option value="adwords_grant">adwords_grant</option>
				<option value="adwords_paid">adwords_paid</option>
				<option value="blog">blog</option>
				<option value="blogher">blogher</option>
				<option value="email">email</option>
				<option value="email_foxflash">email_foxflash</option>
				<option value="email_friend">email_friend</option>
				<option value="email_link">email_link</option>
				<option value="email_welcome">email_welcome</option>
				<option value="facebook">facebook</option>
				<option value="general">general</option>
				<option value="googleplus">googleplus</option>
				<option value="linkedin">linkedin</option>
				<option value="mobile">mobile</option>
				<option value="monthly">monthly</option>
				<option value="neurotalk">neurotalk</option>
				<option value="newsletter">newsletter</option>
				<option value="pinterest">pinterest</option>
				<option value="popup">popup</option>
				<option value="press_release">press_release</option>
				<option value="signature">signature</option>
				<option value="storify">storify</option>
				<option value="twitter">twitter</option>
				<option value="website">website</option>
				<option value="youtube">youtube</option>
			</select>

			<select name="trackingCampaign" id="trackingCampaign">
				<option>Campaign</option>

				<optgroup label="General">
					<option value="thinkable">thinkable</option>
					<option value="michaeljfoxshow">michaeljfoxshow</option>
					<option value="solicitation">solicitation</option>
					<option value="patientprofile">patientprofile</option>
				</optgroup>

				<optgroup label="Research Partnerships">
					<option value="foxtrialfinder">foxtrialfinder</option>
					<option value="hottopics">hottopics</option>
					<option value="ppmi">ppmi</option>
					<option value="smellsurvey">smellsurvey</option>
				</optgroup>

				<optgroup label="Team Fox">
					<option value="chicagomarathon">chicagomarathon</option>
					<option value="chicagoyps">chicagoyps</option>
					<option value="foxfotofriday">foxfotofriday</option>
					<option value="marathon2013">marathon2013</option>
					<option value="newyorkyps">newyorkyps</option>
					<option value="noagelimitforteamfox">noagelimitforteamfox</option>
					<option value="sanfranciscoyps">sanfranciscoyps</option>
					<option value="summerseries">summerseries</option>
					<option value="teamfoxathlete">teamfoxathlete</option>
					<option value="teamfoxevent">teamfoxevent</option>
					<option value="teamfoxmember">teamfoxmember</option>
					<option value="teamfoxmemberinterview">teamfoxmemberinterview</option>
					<option value="torontomarathon">torontomarathon</option>
				</optgroup>
			</select>

			<input type="text" placeholder="Particular Content's Name" name="trackingSpecificCampaign" id="trackingSpecificCampaign" /><br>
			<input type="url" name="trackingURL" id="trackingURL" style="width:460px;" placeholder="Website URL" />
			<br>
			<p>Your link is:<br>
			<span id="finalTrackingLink">Not ready yet. You need to fill in all of the fields above.</span>
			</p> -->

	</div>


	<div id="emailRequest" class="requestSection">
		<p>Steps:</p>
		<ol>
			<li>Add email to the MJFF Email Calendar in Outlook one week prior to delivery.</li>
			<li>Fill in this <a href="mailto:cases@michaeljfox.fogbugz.com?subject=Email Request&body=Subject Line:%0D%0A%0D%0AAudience:%0D%0A%0D%0A%0D%0A%0D%0ASuppression:%0D%0A%0D%0A%0D%0A%0D%0AImage: (if available, attach to this email)%0D%0A%0D%0A%0D%0A%0D%0AEmail Content: %0D%0A%0D%0A"> email template</a> the day before delivery by 2pm.</li>
		</ol>
		

	</div>


<?php 
}
?>
</div>
<div class="footer">
</div>
    </body>
</html>