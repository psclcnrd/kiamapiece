$(document).ready(function() {

	$('#btLogin').button();
	$('#btSearch').button();
	
	// Juste pour deboggage
	$('input[name="loginEmail"]').val('pascal.conrad@gmail.com');
	$('input[name="loginPassword"]').val('khPcMpw');
	
	/**
	 * Controle du login de l'application
	 */
	$('#btLogin').click(function() {
		var id=$('input[name="loginEmail"]').val();
		var pwd=$('input[name="loginPassword"]').val();
		$.ajax({
			url : "/login",
			dataType : 'json',
			data : {log_id : id, log_pwd : pwd},
			success : function(data,statusText,jqXHR) {
				if (data.status=="OK") {
					$('#connectBox').fadeOut(400);
				    $('#infoLogin').append(data.Surname+" "+data.Name);
				    $('#infoLogin').fadeIn(400);
			    }
			}
		});
	});
	
	$('#btSearch').click(function() {
		$.ajax({
			url : "/search/list",
			dataType : 'json',
			data : {
				     searchRegionId : $('select[name="searchRegionId"]').val(),
				     searchBrandId : $('select[name="searchBrandId"]').val(),
				     searchAptId : $('select[name="searchAptId"]').val(),
				     searchPctId : $('select[name="searchPctId"]').val(),
				   },
			success : function(data,statusText,jqXHR) {
				if (data.status=="OK") {
					var html="<table><tr><th>"+data.th_marque+"</th>";
					$('#dataBlock').empty();
					$('#dataBlock').html(data);
			    }
			}
		}); 
	});
});
