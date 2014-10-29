var staff = {
		
	};



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
