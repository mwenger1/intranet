function identifySubmitter(email){
	var emails = {"mwenger@michaeljfox.org":"Mike","lfreeman@michaeljfox.org":"Laura", "amartig@michaeljfox.org":"Adria", "alee@michaeljfox.org":"Alan", "ageldmacher@michaeljfox.org":"Alexandra", "awoodhouse@michaeljfox.org":"Alexandra", "aurkowitz@michaeljfox.org":"Alison", "awhite@michaeljfox.org":"Annesha", "acrowther@michaeljfox.org":"Ashleigh", "blong@michaeljfox.org":"Brennan", "bfiske@michaeljfox.org":"Brian", "cbrdey@michaeljfox.org":"Christina", "cmeunier@michaeljfox.org":"Claire", "cmarshall@michaeljfox.org":"Claudia", "cgeddes@michaeljfox.org":"Colleen", "dherron@michaeljfox.org":"Damaris", "dbrooks@michaeljfox.org":"Debi", "dking@michaeljfox.org":"Dina", "ejoyce@michaeljfox.org":"Elizabeth", "eamanfu@michaeljfox.org":"Eric", "fpaulino@michaeljfox.org":"Felix", "gleung@michaeljfox.org":"Gary", "gallen@michaeljfox.org":"Gloria", "gqadri@michaeljfox.org":"Gloria", "haskew@michaeljfox.org":"Haley", "hnazardejaucourt@michaeljfox.org":"Hallie Nazar de", "hoppenheimer@michaeljfox.org":"Hannah", "hteichholtz@michaeljfox.org":"Holly", "jeberling@michaeljfox.org":"Jamie", "jrice@michaeljfox.org":"Jason", "jmartz@michaeljfox.org":"Joanne", "jweinstein@michaeljfox.org":"Josh", "kwimberly@michaeljfox.org":"K.L.", "krivera@michaeljfox.org":"Katherine", "kvestuto@michaeljfox.org":"Kathleen", "kforsberg@michaeljfox.org":"Katie", "ckopil@michaeljfox.org":"Katie", "kpeabody@michaeljfox.org":"Katie", "kkubota@michaeljfox.org":"Ken", "kbrown@michaeljfox.org":"Kimberly", "kmilliron@michaeljfox.org":"Kristen", "kpate@michaeljfox.org":"Kristin", "klopez@michaeljfox.org":"Kristina", "Kdave@michaeljfox.org":"Kuldip", "ldallepazze@michaeljfox.org":"Laura Dalle", "landerson@michaeljfox.org":"Lauren", "lwordham@michaeljfox.org":"Laxmi", "lfleisch@michaeljfox.org":"Leslie", "lcappelletti@michaeljfox.org":"Lily", "ediemer@michaeljfox.org":"Liz", "lvincent@michaeljfox.org":"Lona", "llong@michaeljfox.org":"Lura", "lkaur@michaeljfox.org":"Luvleen", "lherron@michaeljfox.org":"Lydia", "mrao@michaeljfox.org":"Madhavi", "mmcguire@michaeljfox.org":"Maggie", "mbaptista@michaeljfox.org":"Marco", "mfrasier@michaeljfox.org":"Mark", "mfacheris@michaeljfox.org":"Maurizio", "Mhaupt@michaeljfox.org":"Meredith", "mgolombuski@michaeljfox.org":"Michele B.", "maquino@michaeljfox.org":"Michelle", "nherpich@michaeljfox.org":"Nate", "nlaffir@michaeljfox.org":"Nazreen", "njeffers@michaeljfox.org":"Nicholas", "nmarino@michaeljfox.org":"Nicolas", "nkelleners@michaeljfox.org":"Nicole", "nwillis@michaeljfox.org":"Nicole", "pradford@michaeljfox.org":"Patricia", "rbulmer@michaeljfox.org":"Rachael", "sfox@michaeljfox.org":"Sam", "sgogolak@michaeljfox.org":"Sara", "sbarnes@michaeljfox.org":"Sarah", "skeating@michaeljfox.org":"Sean", "swalls@michaeljfox.org":"Simone", "schowdhury@michaeljfox.org":"Sohini", "sdas@michaeljfox.org":"Sonal", "spaddock@michaeljfox.org":"Stephanie", "sstartz@michaeljfox.org":"Stephanie", "sgrubb@michaeljfox.org":"Stephen", "tsherer@michaeljfox.org":"Todd", "tiacolucci@michaeljfox.org":"Toni", "tmumford@michaeljfox.org":"Tracey", "varnedo@michaeljfox.org":"Vanessa", "venos@michaeljfox.org":"Veronique"};
	var name = emails[email];
	return name;
}


$(document).ready(function(){
	$(".requestSection").hide();
	$("#requestOptions").hide();
	
	/* Figure out user */

	$("#email").bind('blur keyup',function(e) { 
		if (e.type == 'blur' || e.keyCode == '13'){ 

			var tmpValue = $(this).val();
			if(!tmpValue){
				$("#requestOptions").hide();
				$("#requestOptionsError").hide();
			} else {
				var submitterName = identifySubmitter(tmpValue);
				if (submitterName){
					$("#submitterName").text(submitterName);
					$("#requestOptions").show();
					$("#requestOptionsError").html("");
				} else{
					$("#requestOptions").hide();
					$("#requestOptionsError").show().html("This email is not valid. Make sure you use @michaeljfox.org. If you are a new employee, email <a href='mailto:mwenger@michaeljfox.org' style='color:#395C70;''>mwenger@michaeljfox.org</a> to add your name to the list.");
				}
			}
		}
	});


	$('#requestType').change(function(){

		var tempValue = $(this).val();

		/* Vanity URL */
		
		if (tempValue == "Vanity URL"){
			$(".requestSection").hide();
			$("#vanityURL").show();
			$("#vanityAddress").focus();
		} else if (tempValue == "Event on Calendar"){
			$(".requestSection").hide();
			$("#calendarRequest").show();	
		} else if (tempValue == "Blog Post"){
			$(".requestSection").hide();
			$("#blogPost").show();
		} else if (tempValue == "Bug Discovered"){
			$(".requestSection").hide();
			$("#bugRequest").show();
		} else if (tempValue == "Check on Status"){
			$(".requestSection").hide();
			$("#fogbugzRequest").show();			

		} else if (tempValue == "Designed Image"){
			$(".requestSection").hide();
			$("#createImage").show();	

		} else if (tempValue == "Edit text"){
			$(".requestSection").hide();
			$("#editText").show();	

		} else if (tempValue == "FTF Analytics Analysis"){
			$(".requestSection").hide();
			$("#ftfAnalytics").show();	

		} else if (tempValue == "Google Analytics Analysis"){
			$(".requestSection").hide();
			$("#googleAnalytics").show();	
		} else if (tempValue == "Social Posts"){
			$(".requestSection").hide();
			$("#socialPosts").show();	
		} else if (tempValue == "Send out Email"){
			$(".requestSection").hide();
			$("#emailRequest").show();
		} else if (tempValue == "Custom Tracking URL"){
			$(".requestSection").hide();
			$("#customTrackingRequest").show();
		} else if (tempValue == "New Web Page"){
			$(".requestSection").hide();
			$("#newPageRequest").show();


		} else{
			$(".requestSection").hide();
		}

		

	});

	/* VANITY URL TRACKING = Dynamically Generate Link */
    $("select[name=trackingSource],select[name=trackingMedium],select[name=trackingCampaign],input[name=trackingSpecificCampaign],input[name=trackingURL").change(function(){
	    var source = $("select[name=trackingSource]").val();
	    var medium = $("select[name=trackingMedium]").val();
	    var campaign = $("select[name=trackingCampaign]").val();
	    var specificCampaign = $("input[name=trackingSpecificCampaign]").val();
	    var url = $("input[name=trackingURL").val().trim();

	    if (source == "Source" || medium == "Medium" || campaign == "Campaign" || specificCampaign == "" || url == ""){
	        $("#finalTrackingLink").html("Not ready yet. You need to fill in all of the fields above.");
	    } else{
	    	if (url.indexOf("?") == -1){
    			url = url + "?";
    		}
			finalURL = url + "&utm_source=" + source + "&utm_medium=" + medium + "&utm_content=" + campaign + "&utm_campaign=" + specificCampaign + "&s_src=" + specificCampaign + "&s_subsrc=" + medium;
			$("#finalTrackingLink").html("<a target='_blank' href='" + finalURL + "'>" + finalURL + "</a><br><br>Make sure it works before using!");
	    }
	})
});