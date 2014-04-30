var staff = {
		"STRATEGY":{
			"sstartz@michaeljfox.org":"Stephanie",
			"mwenger@michaeljfox.org":"Mike",
			"skeating@michaeljfox.org":"Sean",
			"lwordham@michaeljfox.org":"Laxmi",
			"nmarino@michaeljfox.org":"Nicolas",
			"sbourque@michaeljfox.org":"Sue",
			"njeffers@michaeljfox.org":"Nicholas",
			"nryerson@michaeljfox.org":"Nancy",
			"hoppenheimer@michaeljfox.org":"Hannah"
		},
		"RESPART":{
			"cmeunier@michaeljfox.org":"Claire",
			"ldallepazze@michaeljfox.org":"Laura Dalle",
			"schowdhury@michaeljfox.org":"Sohini",
			"tmumford@michaeljfox.org":"Tracey",
			"varnedo@michaeljfox.org":"Vanessa",
			"lcappelletti@michaeljfox.org":"Lily",
			"ejoyce@michaeljfox.org":"Elizabeth",
			"kforsberg@michaeljfox.org":"Katie",
			"kwasilewski@michaeljfox.org":"Kelsey",
			"llong@michaeljfox.org":"Lura",
			"kpeabody@michaeljfox.org":"Katie",
			"cmarshall@michaeljfox.org":"Claudia"
		},
		"SENIOR":{
			"dbrooks@michaeljfox.org":"Debi",
			"awhite@michaeljfox.org":"Annesha",
			"tsherer@michaeljfox.org":"Todd"

		},
		"TEAMFOX":{
			"ediemer@michaeljfox.org":"Liz",
			"awoodhouse@michaeljfox.org":"Alexandra",
			"spaddock@michaeljfox.org":"Stephanie",
			"sfox@michaeljfox.org":"Sam",
			"klopez@michaeljfox.org":"Kristina",
			"jrice@michaeljfox.org":"Jason"
		},
		"DEV":{
			"kmilliron@michaeljfox.org":"Kristen",
			"hfaba@michaeljfox.org":"Hayley",
			"skelly@michaeljfox.org":"Sheila",
			"haskew@michaeljfox.org":"Haley",
			"landerson@michaeljfox.org":"Lauren",
			"lfleisch@michaeljfox.org":"Leslie",
			"lkaur@michaeljfox.org":"Luvleen",
			"mrao@michaeljfox.org":"Madhavi",
			"mgolombuski@michaeljfox.org":"Michele B.",
			"maquino@michaeljfox.org":"Michelle",
			"nkelleners@michaeljfox.org":"Nicole",
			"rbulmer@michaeljfox.org":"Rachael",
			"sgogolak@michaeljfox.org":"Sara",
			"sbarnes@michaeljfox.org":"Sarah",
			"tiacolucci@michaeljfox.org":"Toni",
			"venos@michaeljfox.org":"Veronique",
			"dking@michaeljfox.org":"Dina",
			"kpate@michaeljfox.org":"Kristin",
			"hnazardejaucourt@michaeljfox.org":"Hallie Nazar de"
		},
		"ADMIN":{
			"jmartz@michaeljfox.org":"Joanne",
			"eamanfu@michaeljfox.org":"Eric",
			"acrowther@michaeljfox.org":"Ashleigh",
			"gleung@michaeljfox.org":"Gary",
			"sgrubb@michaeljfox.org":"Stephen",
			"gallen@michaeljfox.org":"Gloria",
			"gqadri@michaeljfox.org":"Gloria",
			"cgeddes@michaeljfox.org":"Colleen",
			"dherron@michaeljfox.org":"Damaris",
			"lfreeman@michaeljfox.org":"Laura",
			"fpaulino@michaeljfox.org":"Felix",
			"alee@michaeljfox.org":"Alan",
			"swalls@michaeljfox.org":"Simone",
			"kwimberly@michaeljfox.org":"K.L.",
			"kbrown@michaeljfox.org":"Kimberly"
		},
		"RESOPS":{
			"aurkowitz@michaeljfox.org":"Alison",
			"nlaffir@michaeljfox.org":"Nazreen",
			"dfleit@michaeljfox.org":"David",
			"lherron@michaeljfox.org":"Lydia",
			"jeberling@michaeljfox.org":"Jamie",
			"Kdave@michaeljfox.org":"Kuldip",
			"lvincent@michaeljfox.org":"Lona",
			"mbaptista@michaeljfox.org":"Marco",
			"mfrasier@michaeljfox.org":"Mark",
			"mfacheris@michaeljfox.org":"Maurizio",
			"mhaupt@michaeljfox.org":"Meredith",
			"nwillis@michaeljfox.org":"Nicole",
			"pradford@michaeljfox.org":"Patricia",
			"sdas@michaeljfox.org":"Sonal",
			"amartig@michaeljfox.org":"Adria",
			"blong@michaeljfox.org":"Brennan",
			"bfiske@michaeljfox.org":"Brian",
			"ageldmacher@michaeljfox.org":"Alexandra",
			"krivera@michaeljfox.org":"Katherine",
			"kvestuto@michaeljfox.org":"Kathleen",
			"ckopil@michaeljfox.org":"Katie",
			"jlangon@michaeljfox.org":"Jesse",
			"lgellner@michaeljfox.org":"Lisa",
			"kkubota@michaeljfox.org":"Ken"
		},
		"MARCOMM":{
			"mmcguire@michaeljfox.org":"Maggie",
			"hteichholtz@michaeljfox.org":"Holly",
			"cbrdey@michaeljfox.org":"Christina",
			"ksawicki@michaeljfox.org":"Kim S",
			"kcastleberry@michaeljfox.org":"Kim C",
			"communicationsintern@michaeljfox.org":"Ashleigh"
		}
	};

var deptChampion = {"STRATEGY":"Stephanie Startz", "RESPART":"Claire Meunier","TEAMFOX":"Jason Rice","DEV":"Jason Rice", "ADMIN":"Joanne Martz","RESOPS":"Alison Urkowitz","MARCOMM":"Christina Brdey"};


function identifySubmitter(email, staff){
	for (var department in staff){
		var tmpDept = staff[department];
		for (var tmpEmail in tmpDept) {
			if (tmpEmail == email){
				personArray = [];
				personArray[0] = staff[department][tmpEmail];
				personArray[1] = department;
				// personArray[1] = "STRATEGY";

				return personArray;
			}else{
			}
		}
	}
return false;

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
				var submitterName = identifySubmitter(tmpValue, staff);
				if (submitterName[0]){
					$("#submitterName").text(submitterName[0]);
					$("input[name=fromemail]").val(tmpValue);
					$("input[name=department]").val(submitterName[1]);
					var dept = submitterName[1];
					$(".deptChampion").text(deptChampion[dept]);
					console.log('this ran');
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
		} else if (tempValue == "Edit Video"){
			$(".requestSection").hide();
			$("#editVideo").show();
		} else if (tempValue == "Upload Youtube"){
			$(".requestSection").hide();
			$("#uploadYoutube").show();
		} else if (tempValue == "Edit bio"){
			$(".requestSection").hide();
			$("#staffBioRequest").show();
		} else if (tempValue == "Add Rfa"){
			$(".requestSection").hide();
			$("#addRfa").show();
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
