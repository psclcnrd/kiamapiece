$(document).ready(function() {

	$('div.overflowHeader').hide();
	$(document).scroll(function(event) {
		var pos=$(this).scrollTop();
		if (pos>90) $('div.overflowHeader').slideDown(50);else $('div.overflowHeader').slideUp(50);
	});
	
	$('#btLogin').button();
	$('#btLogout').button();	
	$('#btSearch').button();
	
	// Juste pour deboggage
	//$('input[name="loginEmail"]').val('pascal.conrad@gmail.com');
	//$('input[name="loginPassword"]').val('khPcMpw');
	
	$('input[name="Town"]').autocomplete();
	
	/**
	 * Controle du login de l'application
	 */
	$('#btLogin').click(function() {
		var id=$('input[name="loginEmail"]').val();
		var pwd=$('input[name="loginPassword"]').val();
		$.ajax({
			url : "/user/login",
			dataType : 'json',
			data : {log_id : id, log_pwd : pwd},
			success : function(data,statusText,jqXHR) {
				if (data.status=="OK") {
					window.location.href='/search';
					//$('#connectBox').fadeOut(400);
				    //$('#theName').text(data.Name);
				    //$('#infoLogin').fadeIn(400);
			    } else {
			    	$('#errorLogin').fadeIn(400);
			    	$('#errorLogin').fadeOut(2000);
			    }
			}
		});
	});
	
	/**
	 * Bouton de recherche principale
	 */
	$('#btSearch').click(function() {
	     var searchRegionId = $('select[name="searchRegionId"]').val();
	     var searchBrandId = $('select[name="searchBrandId"]').val();
	     var searchAptId = $('select[name="searchAptId"]').val();
	     var searchPctId = $('select[name="searchPctId"]').val();
	     var url="/search/list?searchRegionId="+searchRegionId+"&searchBrandId="+searchBrandId+"&searchAptId="+searchAptId+"&searchPctId="+searchPctId;
	     window.location.href=url;
	});
	
	/**
	 * Menu principal
	 */
	$('span.menuLink').click(function(){
		var href=$(this).data('href');
		window.location.href=href;
	});
	/**
	 * Suppression d'une pièce mise à disposition
	 */
	$('span.btDelete').click(function(event) {
		var id=$(this).attr('id');
		var action=$(this).data('action');
		var url=action+"/"+id;
		if (!$('div.dlgConfirm').length) {
			$("body").append("<div class='dlgConfirm'>Confirmation de la suppression</div>");
		}
		$('div.dlgConfirm').dialog({
			title : 'Confirmation',
			modal : true,
			width : 700,
			autoOpen : true,
			buttons : [
			           {
			        	   text : 'Ok',
			        	   click : function() {
			        		   window.location.href=url;
			        	   }
			           },
			           {
			        	   text : 'Annuler',
			        	   click : function() {
			        		   $(this).dialog("close");
			        	   }
			           }
				
			]
		});			
	});
	/**
	 * Modification d'une pièce
	 */
	$('span.btEdit').click(function(event) {
		var id=$(this).attr('id');
		var action=$(this).data('action');
		var url=action+"/"+id;
		window.location.href=url;
	});
	/**
	 * Notifier la réception
	 */
	$('span.btReceive').click(function(event) {
		var id=$(this).attr('id');
		var action=$(this).data('action');
		var url=action+"/"+id;
		window.location.href=url;
	});
	/**
	 * Envoyer un message
	 */
	$('span.btMessage').click(function(event) {
		var id=$(this).attr('id');
		var action=$(this).data('action');
		var url=action+"/"+id;
		window.location.href=url;
	});
	//----------------------------------------------------------------------------------------------------------
	/*
	 * ZONE D'EDITION
	 */
	/**
	 * Recherche si il y a une zone d'edition
	 */
	if ($('div.editor').length) {
		tinymce.init({
			selector : "div.editor textarea",
			height : 350,
			resize : false,
			menubar : false,
			toolbar: "undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor"
		});
	}
	/**
	 * Texte de saisie du code postal
	 */
	$('input[name="PostalCode"]').change(function() {
		$.ajax({
			url : "/user/towns",
			dataType : 'json',
			data : {
				     postalCode : $(this).val(),
				   },
			success : function(data,statusText,jqXHR) {
				if (data.status=="OK") {
					var t=new Array;
                   //$('select[name="Town"]').empty();
                   for(var i=0;i<data.towns.length;i++) {
                	   //$('select[name="Town"]').append("<option value='"+data.towns[i].Name+"'>"+data.towns[i].Name+"</option>");
                	   t[i]=data.towns[i].Name;
                   }
                   $('input[name="Town"]').autocomplete("option","source",t);
			    }
			}
		}); 
	});
	if ($('input[name="PostalCode"]').val()!="") $('input[name="PostalCode"]').change();
	/**
	 * Text adresse mail, contrôle de son unicité
	 */
	$('input[name="Email"]').change(function(event){
		$.ajax({
			url : "/user/verifmail",
			dataType : 'json',
			data : {
				     email : $(this).val(),
				   },
			success : function(data,statusText,jqXHR) {
				if (data.exist!=0) {
					var parent=$('input[name="Email"]').parent();
					$(parent).next().text('Adresse mail existante');
			    }
			}
		});		
	});
	if ($('#btSubmit').length) {
		$('#btSubmit').click(function(event) {
			var client=$(this).data('client');
			var role=$(this).data('role');
			if (client=='user') {
		    	if (role=='add') {
					$.ajax({
						url : "/user/verifmail",
						dataType : 'json',
						data : {
							     email : $('input[name="Email"]').val(),
							   },
						success : function(data,statusText,jqXHR) {
							if (data.exist!=0) {
								var parent=$('input[name="Email"]').parent();
								$(parent).next().text('Adresse mail existante');
						    } else {
						    	  var pwd1=$('input[name="Password"]').val();
						    	  var pwd2=$('input[name="PasswordRetype"]').val();
						    	  if (pwd1!=pwd2) {
		  					    		var parent=$('input[name="Password"]').parent();
										$(parent).next().text('Mot de passe différents');
							    	} else
							    		$('form:first').submit();
						    }
						},
					});
		    	} 
		    	if (role=='pwd') {
			    	  var pwd1=$('input[name="Password"]').val();
			    	  var pwd2=$('input[name="PasswordRetype"]').val();
			    	  if (pwd1!=pwd2) {
					    	var parent=$('input[name="Password"]').parent();
							$(parent).next().text('Mot de passe différents');
				    	} else
				    		$('form:first').submit();		    		
		    	}
		    	if ((role!='add') && (role!='pwd'))	$('form:first').submit();
			}
			if (client=='adr') $('form:first').submit();
			if (client=="message") {
				$('form:first').submit();
			}
		});
	}
	//-----
});
