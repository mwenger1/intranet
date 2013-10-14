function identifySubmitter(email){
	var staff = {
		"STRATEGY":{
			"mwenger@michaeljfox.org":"Mike",
			"llong@michaeljfox.org":"Lura",
			"skeating@michaeljfox.org":"Sean",
			"lwordham@michaeljfox.org":"Laxmi",
			"sstartz@michaeljfox.org":"Stephanie",
			"nmarino@michaeljfox.org":"Nicolas",
			"hoppenheimer@michaeljfox.org":"Hannah"
		},
		"RESPART":{
			"ldallepazze@michaeljfox.org":"Laura Dalle",
			"schowdhury@michaeljfox.org":"Sohini",
			"tmumford@michaeljfox.org":"Tracey",
			"lcappelletti@michaeljfox.org":"Lily",
			"ejoyce@michaeljfox.org":"Elizabeth",
			"cmeunier@michaeljfox.org":"Claire",
			"cmarshall@michaeljfox.org":"Claudia"
		},
		"SENIOR":{
			"dbrooks@michaeljfox.org":"Debi",
			"awhite@michaeljfox.org":"Annesha",
			"kpeabody@michaeljfox.org":"Katie",
			"tsherer@michaeljfox.org":"Todd"

		},
		"TEAMFOX":{
			"awoodhouse@michaeljfox.org":"Alexandra",
			"spaddock@michaeljfox.org":"Stephanie",
			"ediemer@michaeljfox.org":"Liz",
			"sfox@michaeljfox.org":"Sam",
			"klopez@michaeljfox.org":"Kristina",
			"jrice@michaeljfox.org":"Jason"
		},
		"DEV":{
			"kmilliron@michaeljfox.org":"Kristen",
			"haskew@michaeljfox.org":"Haley",
			"landerson@michaeljfox.org":"Lauren",
			"lfleisch@michaeljfox.org":"Leslie",
			"lkaur@michaeljfox.org":"Luvleen",
			"mrao@michaeljfox.org":"Madhavi",
			"Mhaupt@michaeljfox.org":"Meredith",
			"mgolombuski@michaeljfox.org":"Michele B.",
			"maquino@michaeljfox.org":"Michelle",
			"nlaffir@michaeljfox.org":"Nazreen",
			"njeffers@michaeljfox.org":"Nicholas",
			"nkelleners@michaeljfox.org":"Nicole",
			"rbulmer@michaeljfox.org":"Rachael",
			"sgogolak@michaeljfox.org":"Sara",
			"sbarnes@michaeljfox.org":"Sarah",
			"swalls@michaeljfox.org":"Simone",
			"tiacolucci@michaeljfox.org":"Toni",
			"varnedo@michaeljfox.org":"Vanessa",
			"venos@michaeljfox.org":"Veronique",
			"dking@michaeljfox.org":"Dina",
			"kpate@michaeljfox.org":"Kristin",
			"hnazardejaucourt@michaeljfox.org":"Hallie Nazar de"
		},
		"ADMIN":{
			"eamanfu@michaeljfox.org":"Eric",
			"gleung@michaeljfox.org":"Gary",
			"sgrubb@michaeljfox.org":"Stephen",
			"lherron@michaeljfox.org":"Lydia",
			"gallen@michaeljfox.org":"Gloria",
			"gqadri@michaeljfox.org":"Gloria",
			"cgeddes@michaeljfox.org":"Colleen",
			"dherron@michaeljfox.org":"Damaris",
			"lfreeman@michaeljfox.org":"Laura",
			"fpaulino@michaeljfox.org":"Felix",
			"jeberling@michaeljfox.org":"Jamie",
			"alee@michaeljfox.org":"Alan",
			"jmartz@michaeljfox.org":"Joanne",
			"kwimberly@michaeljfox.org":"K.L.",
			"kbrown@michaeljfox.org":"Kimberly"
		},
		"RESOPS":{
			"Kdave@michaeljfox.org":"Kuldip",
			"lvincent@michaeljfox.org":"Lona",
			"mbaptista@michaeljfox.org":"Marco",
			"mfrasier@michaeljfox.org":"Mark",
			"mfacheris@michaeljfox.org":"Maurizio",
			"nwillis@michaeljfox.org":"Nicole",
			"pradford@michaeljfox.org":"Patricia",
			"sdas@michaeljfox.org":"Sonal",
			"amartig@michaeljfox.org":"Adria",
			"acrowther@michaeljfox.org":"Ashleigh",
			"blong@michaeljfox.org":"Brennan",
			"bfiske@michaeljfox.org":"Brian",
			"aurkowitz@michaeljfox.org":"Alison",
			"ageldmacher@michaeljfox.org":"Alexandra",
			"krivera@michaeljfox.org":"Katherine",
			"kvestuto@michaeljfox.org":"Kathleen",
			"kforsberg@michaeljfox.org":"Katie",
			"ckopil@michaeljfox.org":"Katie",
			"kkubota@michaeljfox.org":"Ken"
		},
		"MARCOMM":{
			"mmcguire@michaeljfox.org":"Maggie",
			"hteichholtz@michaeljfox.org":"Holly",
			"cbrdey@michaeljfox.org":"Christina",
			"communicationsintern@michaeljfox.org":"Ashleigh"
		}
	};

	for (var department in staff){
		var tmpDept = staff[department];
		for (var tmpEmail in tmpDept) {
			if (tmpEmail == email){
				console.log('this ran');
				personArray = [];
				personArray[0] = staff[department][tmpEmail];
				personArray[1] = department;
				// personArray[1] = "STRATEGY";
				
				return personArray;
			}else{
				console.log("not a match");
			}
		}
	}
return false;

}
var person = identifySubmitter("mwenger@michaeljfox.org");
console.log(person);

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
				if (submitterName[0]){
					$("#submitterName").text(submitterName[0]);
					$("input[name=fromemail]").val(tmpValue);
					$("input[name=department]").val(submitterName[1]);
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
		} else if (tempValue == "CRM Analytics Analysis"){
			$(".requestSection").hide();
			$("#crmAnalytics").show();	

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
		} else if (tempValue == "Not Sure"){
			$(".requestSection").hide();
			$("#otherRequest").show();
		} else{
			$(".requestSection").hide();
		}

		

	});

	$("select[name=imagetype]").change(function(){
		var tmp = $(this).val();
		if (tmp == "other"){
			$("#hiddenMacroDimensions").slideDown();
		} else{
			$("#hiddenMacroDimensions").hide();
		}
	})


});