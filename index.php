<?php
$method_id = $_REQUEST["method"];

if($method_id == 'dncon2')
{
	$method_id='dncon2';
}else if($method_id == 'confold2')
{
	$method_id='confold2';
}else if($method_id == 'deepsf')
{
	$method_id='deepsf';
}else{
	
	$method_id='multicom';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CASP13 dashboard</title>
    <meta charset="UTF-8">
    
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<link rel="stylesheet" href="style/style.css">
  <style>
    .caret {
      margin-left: 8px;
    }
    
    .target-btns:hover.btn:hover {
      background-color: whitesmoke;
    }
    
    .target-btns {
      background-color: white;
    }
    
    .dropdown-submenu:hover {
      cursor: pointer;
    }
    
    .dropdown-menu-methods {
      padding: 5px;
    }
    .dropdown-menu-methods:hover {
      cursor: pointer;
      background-color: whitesmoke;
    }
    
    .loader {
      border: 5px solid lightgray; /* Light grey */
      border-top: 5px solid #3498db; /* Blue */
      border-radius: 50%;
      width: 20px;
      height: 20px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .carousel-control.left {
      background-image: none;
    }

    .carousel-control.right {
      background-image: none;
    }
  </style>
</head>

<script type="text/javascript">
function openPopup(updateid) {
	var popup = window.open("", "", "width=1000,height=480,resizeable,scrollbars");
	var align_path = document.getElementById(updateid).value;
	//alert(align_path);
	var client = new XMLHttpRequest();
	client.open('GET', align_path);
	jQuery.get(align_path, function(data) {
		//alert(data);
		
		var lines = data.split('\n');
		var tableContent = '<h2>Multiple sequence alignment Alignment</h2>';
		for(var line = 0; line < lines.length; line++){

     		tableContent += lines[line]+"</br>\n";
		}
				
		
		 popup.document.write(tableContent);
		  popup.document.close();
		  if (window.focus) 
			popup.focus();
	});
 
}
  var __target = "";
  function loadTarget(e){
//    console.log(e);
    document.getElementById("targetMenu").innerHTML = e.attributes.value.textContent + "<span class='caret'></span>";
    $(".activeDropdown").hide();
    $(".activeDropdown").removeClass("activeDropdown");
    methodName = $("#dropdown-description").text();
    var target = e.value;
    target = target.replace(/\n/g, '');
    __target = target;
	model = 1;
    if ($("#refinedCheck").prop("checked")) {
      Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
      if (!$("#initialCheck").prop("checked")) append = "";
      rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
      jmol_filepath = "load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;", "frame ALL; spin on; cartoon only; color {file=1} group;";
      jmol_frame_instructions = "frame ALL; spin on; cartoon only; color {file=1} group;";
    }
	else {
      $("#refinedCheck").prop("checked", true);
      rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
      jmol_filepath = "load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;";
      jmol_frame_instructions = "frame ALL; spin on; cartoon only; color {file=1} group;";
	}
    append = "APPEND";
    $("#modelTitle").html("Predicted Model 1");
  };
  
  function getTarget(){
    return __target;
  }
    $(document).ready(function() {
       $("#title-menu").click(function() {
           var target = String($(this).val());
           $("#dropdown-description").html(target.toUpperCase() + '<span class="caret"></span>');
            $.get("updateMethod.php", {method:target}, function(response){
                $("#targetMenu").html(response);
                });
           $(".comment_box").html(target.toUpperCase() + " Comments");
           location.href = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/index.php?method=" + target;
            });
    });
	
    $(document).ready(function() {
      // Fills the table for each model. The View Model, Align, etc.
       $("#view_targets").click(function() {
           var methodName = $("#dropdown-description").text();
			var target = getTarget();
            $("#dropdownMenu1").html(target);
			target = target.replace(/\n/g, '');
			model = 1;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			document.getElementById('viewAlign1').value =aln_file;
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			document.getElementById('viewAlign5').value =aln_file;
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			
			$.get(fasta_file)
			.done(function() { 
				// exists code 
					var client = new XMLHttpRequest();
					client.open('GET', fasta_file);
					jQuery.get(fasta_file, function(data) {
						document.getElementById('protein_sequence').value =data;
					});
			}).fail(function() { 
				// not exists code
			})
			
			
          
			//  load the protein template rank
			var fasta_rank = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash';
			$.get(fasta_rank)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
					client.open('GET', fasta_rank);
                    
					jQuery.get(fasta_rank, function(data) {
						if(document.getElementById('template_rank'))
						{
							document.getElementById('template_rank').value =data;
						}
					});
		
			}).fail(function() { 
				// not exists code
			})

		   
          
			//load fold image
			var deepsf_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model1.foldmarker.jpeg';
			if(document.getElementById('deepsf_fold_image'))
			{
				document.getElementById('deepsf_fold_image').src = deepsf_file_map;
			}
			
			
			//alert('here');
			//  load the protein predicted contact
			var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.rr';

			$.get(contact_file)
			.done(function() { 
				// exists code 
				client = new XMLHttpRequest();
				client.open('GET', contact_file);
					jQuery.get(contact_file, function(data) {
						if(document.getElementById('confold_contact'))
						{
							document.getElementById('confold_contact').value =data;
						}
					});
			}).fail(function() { 
				// not exists code
			})

		
			
			//load contact map
			var contact_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.cmap.png';
			if(document.getElementById('confold_contact_map'))
			{
				document.getElementById('confold_contact_map').src =contact_file_map;
			}
		  
		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
			$.get(comment_file)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', comment_file);
				jQuery.get(comment_file, function(data) {
					document.getElementById("edit_comment2").readOnly = true;
					document.getElementById('edit_comment2').value =data;
					document.getElementById('edit_comment2').scrollTop=document.getElementById('edit_comment2').scrollHeight;
				});
			}).fail(function() { 
				// not exists code
				document.getElementById("edit_comment2").readOnly = true;
				document.getElementById('edit_comment2').value ='';
				document.getElementById('edit_comment2').scrollTop=document.getElementById('edit_comment2').scrollHeight;
			})
			
			
			// update the rank list 
			var dashfile = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash.csv';
			
			
			//alert(dashfile);
			
			$.get(dashfile)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', dashfile);
				jQuery.get(dashfile, function(data) {
					var lines = data.split('\n');
					var tableContent = '<tbody>';
					for(var line = 0; line < lines.length; line++){
					//for(var line = 0; line < 2; line++){
						var line_array = lines[line].split(',');
						tableContent += '<tr style="border: 1px solid black;">';
						for(var ind = 0; ind < line_array.length; ind++){
							tableContent += '<td style="border: 1px solid black;padding: 6px;">'+line_array[ind]+'</td>';
						}
						tableContent += '</tr>';
					}
					tableContent += '</tbody>';
					$('#template_rank').html(tableContent);
				});
			}).fail(function() { 
				// not exists code
			})
		  
		  
		   // update the deepsf prediction link 
		   
		   //deepsf_web_prediction
		   var deepsf_info = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".info";
		   //alert(deepsf_info);
			$.get(deepsf_info)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', deepsf_info);
				jQuery.get(deepsf_info, function(data) {
					var lines = data.split('\n');
					var deepsf_jobname = lines[1];
					var deepsf_id = lines[3];
					document.getElementById('deepsf_web_prediction_jobid').value =deepsf_id;
					document.getElementById('deepsf_web_prediction_jobname').value =deepsf_jobname;
						
					   //alert("http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+deepsf_jobname+"&protein_id="+deepsf_jobname);
					   document.getElementById('deepsf_iframe').src = "http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+deepsf_jobname+"&protein_id="+deepsf_jobname;
					   document.getElementById('deepsf_iframe').width = "100%";
					   document.getElementById('deepsf_iframe').height = "100%";
				});
			}).fail(function() { 
				// not exists code
			})
		});	
			
    });
	
    $(document).ready(function() {
       $("#dncon2_run").click(function() {
          document.getElementById("dncon2_iframe_loader").style.display = "inline-block";
          var target = String($(this).val());
		  var array_tmp = target.split('.');
		  var targetname=array_tmp[0];
          document.getElementById("dropdownMenu1").innerHTML = targetname + "<span class='caret'></span>"; //changes name to show current target
          $('#dncon2_iframe').load(function(){
            document.getElementById("dncon2_iframe_loader").style.display = "none";
          });
          document.getElementById('dncon2_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw=http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard//MULTICOM_Methods/dncon2/"+target+"&job_id="+targetname;
         document.getElementById("dncon2_iframe").style.height = "2000px";
      });
    });

	
    $(document).ready(function() {
       $("#pdb_contact_analysis1").click(function() {
		   var methodName = $("#dropdown-description").text();
           var target = String($(this).val());
		   var array_tmp = target.split('.');
		   var targetname=array_tmp[0];
		   var model=array_tmp[1];
		   
		   document.getElementById('pdb_contact_analysis_iframe').src="";
		   
		   var targetname_tmp = targetname.split('_'); //2017-11-04_00000004_1_50
		   var targetname_prefix = targetname_tmp[0]+'_'+targetname_tmp[1]+'_'+targetname_tmp[2];
		   var targetname_confold = targetname_prefix+'_71'; // in CAMEO, confold group id is 71
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
			//alert(model_file);
			//alert(contact_file);
			
			$.get(contact_file)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', contact_file);
				jQuery.get(contact_file, function(data) {
					   //alert("http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname);
					   document.getElementById('pdb_contact_analysis_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname;
					   document.getElementById('pdb_contact_analysis_iframe').width = "100%";
					   document.getElementById('pdb_contact_analysis_iframe').height = "100%";
				});
			}).fail(function() { 
				// not exists code
				alert('No contact file found, check <'+contact_file+'>');
			})
			

        });
    });
    $(document).ready(function() {
       $("#pdb_contact_analysis2").click(function() {
		   var methodName = $("#dropdown-description").text();
           var target = String($(this).val());
		   var array_tmp = target.split('.');
		   var targetname=array_tmp[0];
		   var model=array_tmp[1];
		   
		   document.getElementById('pdb_contact_analysis_iframe').src="";
		   var targetname_tmp = targetname.split('_'); //2017-11-04_00000004_1_50
		   var targetname_prefix = targetname_tmp[0]+'_'+targetname_tmp[1]+'_'+targetname_tmp[2];
		   var targetname_confold = targetname_prefix+'_71'; // in CAMEO, confold group id is 71
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
			//alert(model_file);
			//alert(contact_file);
			
			$.get(contact_file)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', contact_file);
				jQuery.get(contact_file, function(data) {
					   alert("http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname);
					   document.getElementById('pdb_contact_analysis_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname;
					   document.getElementById('pdb_contact_analysis_iframe').width = "100%";
					   document.getElementById('pdb_contact_analysis_iframe').height = "100%";
				});
			}).fail(function() { 
				// not exists code
				alert('No contact file found, check <'+contact_file+'>');
			})
			

        });
    });
    $(document).ready(function() {
       $("#pdb_contact_analysis3").click(function() {
		   var methodName = $("#dropdown-description").text();
           var target = String($(this).val());
		   var array_tmp = target.split('.');
		   var targetname=array_tmp[0];
		   var model=array_tmp[1];
		   
		   document.getElementById('pdb_contact_analysis_iframe').src="";
		   var targetname_tmp = targetname.split('_'); //2017-11-04_00000004_1_50
		   var targetname_prefix = targetname_tmp[0]+'_'+targetname_tmp[1]+'_'+targetname_tmp[2];
		   var targetname_confold = targetname_prefix+'_71'; // in CAMEO, confold group id is 71
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
			//alert(model_file);
			//alert(contact_file);
			
			$.get(contact_file)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', contact_file);
				jQuery.get(contact_file, function(data) {
					   alert("http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname);
					   document.getElementById('pdb_contact_analysis_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname;
					   document.getElementById('pdb_contact_analysis_iframe').width = "100%";
					   document.getElementById('pdb_contact_analysis_iframe').height = "100%";
				});
			}).fail(function() { 
				// not exists code
				alert('No contact file found, check <'+contact_file+'>');
			})
			

        });
    });
    $(document).ready(function() {
       $("#pdb_contact_analysis4").click(function() {
		   var methodName = $("#dropdown-description").text();
           var target = String($(this).val());
		   var array_tmp = target.split('.');
		   var targetname=array_tmp[0];
		   var model=array_tmp[1];
		   
		   document.getElementById('pdb_contact_analysis_iframe').src="";
		   var targetname_tmp = targetname.split('_'); //2017-11-04_00000004_1_50
		   var targetname_prefix = targetname_tmp[0]+'_'+targetname_tmp[1]+'_'+targetname_tmp[2];
		   var targetname_confold = targetname_prefix+'_71'; // in CAMEO, confold group id is 71
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
			//alert(model_file);
			//alert(contact_file);
			
			$.get(contact_file)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', contact_file);
				jQuery.get(contact_file, function(data) {
					   alert("http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname);
					   document.getElementById('pdb_contact_analysis_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname;
					   document.getElementById('pdb_contact_analysis_iframe').width = "100%";
					   document.getElementById('pdb_contact_analysis_iframe').height = "100%";
				});
			}).fail(function() { 
				// not exists code
				alert('No contact file found, check <'+contact_file+'>');
			})
			

        });
    });
    $(document).ready(function() {
       $("#pdb_contact_analysis5").click(function() {
		   var methodName = $("#dropdown-description").text();
           var target = String($(this).val());
		   var array_tmp = target.split('.');
		   var targetname=array_tmp[0];
		   var model=array_tmp[1];
		   
		   document.getElementById('pdb_contact_analysis_iframe').src="";
		   var targetname_tmp = targetname.split('_'); //2017-11-04_00000004_1_50
		   var targetname_prefix = targetname_tmp[0]+'_'+targetname_tmp[1]+'_'+targetname_tmp[2];
		   var targetname_confold = targetname_prefix+'_71'; // in CAMEO, confold group id is 71
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
			//alert(model_file);
			//alert(contact_file);
			
			$.get(contact_file)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', contact_file);
				jQuery.get(contact_file, function(data) {
					   alert("http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname);
					   document.getElementById('pdb_contact_analysis_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw="+contact_file+"&pdb_raw="+model_file+"&job_id="+targetname;
					   document.getElementById('pdb_contact_analysis_iframe').width = "100%";
					   document.getElementById('pdb_contact_analysis_iframe').height = "100%";
				});
			}).fail(function() { 
				// not exists code
				alert('No contact file found, check <'+contact_file+'>');
			})
			

        });
    });
	/*
    $(document).ready(function() {
       $("#deepsf_run").click(function() {
           var target = String($(this).val());
		   var array_tmp = target.split('@');
		   var targetname=array_tmp[0];
		   var deepsf_id=array_tmp[1];
		   
  
		   //alert(target);
		   //alert(targetname);
		   //alert("http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+targetname+"&protein_id="+targetname);
           document.getElementById('deepsf_iframe').src = "http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+targetname+"&protein_id="+targetname;
           document.getElementById('deepsf_iframe').width = "100%";
           document.getElementById('deepsf_iframe').height = "100%";
            });
    });
	*/
    $(document).ready(function() {
       $("#deepsf_run").click(function() {
		   var targetname=document.getElementById('deepsf_web_prediction_jobname').value;
		   var deepsf_id=document.getElementById('deepsf_web_prediction_jobid').value;
		   
		   //alert(target);
		   //alert(targetname);
		   //alert("http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+targetname+"&protein_id="+targetname);
           document.getElementById('deepsf_iframe').src = "http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+targetname+"&protein_id="+targetname;
           document.getElementById('deepsf_iframe').width = "100%";
           document.getElementById('deepsf_iframe').height = "100%";
        });
    });
	
	
$(document).ready(function() {
    var opt = $("#dncon2_run option").sort(function (a,b) { return a.value.toUpperCase().localeCompare(b.value.toUpperCase()) });
    $("#dncon2_run").append(opt);
});
$(document).ready(function() {
    var opt = $("#deepsf_run option").sort(function (a,b) { return a.value.toUpperCase().localeCompare(b.value.toUpperCase()) });
    $("#deepsf_run").append(opt);
});
  
// Sort targets by increasing date
$(document).ready(function() {
    var opt = $("#view_targets li").sort(function (a,b) { return a.innerText.toUpperCase().localeCompare(b.innerText.toUpperCase()) });
    var lastDate = "";
    $("#view_targets").html("");
//  console.log(opt);
  var html = "";
  var list = new Array();
    $.each(opt, function(index, value){
        var thisDate = opt[index].textContent.substr(0,10);
//      console.log(value);
        //the first date
        if(lastDate === ""){
          html += "<li class='dropdown-submenu'>";
          html += "<a class='test'>";
          html += thisDate;
          html += "<b class='caret'></b></a>";
          html += "<ul class='dropdown-menu' id="+thisDate+" style='padding: 5px 5px 1px 5px;'>";
          html += "<li>";
          html += value.innerHTML;
          html += "</li>";
          list.push(value);
          lastDate = thisDate;
        }
        else if (lastDate !== thisDate){
          html += "</ul>";
          $("#view_targets").append(html);
          list=[];
          html="";
          html += "<li class='dropdown-submenu'>";
          html += "<a class='test'>" + thisDate + "<b class='caret'></b></a>";
          html += "<ul class='dropdown-menu'  id="+thisDate+" style='padding: 5px 5px 1px 5px;'>";
          html += "<li>";
          html += value.innerHTML;
          html += "</li>";
          list.push(value);
          lastDate = thisDate;
        }
        else if(lastDate === thisDate){
          html += "<li>";
          html += value.innerHTML;
          html += "</li>";
          list.push(value);
          lastDate = thisDate;
        }
        else {
          console.log("Test a failure");
        }
    });
  html += "</div>";
  $("#view_targets").append(html);
  
  // Toggle and show the submenus for the targets which are sorted by date
  $('#view_targets .dropdown-submenu a.test').on("click", function(e){
    $('.activeDropdown').hide();
    $('.activeDropdown').removeClass('activeDropdown');
    $(this).next('ul').toggle();
    $(this).next('ul').addClass('activeDropdown');
    e.stopPropagation();
    e.preventDefault();
  });
});

$(document).ready(function() {
    var opt = $("#viewButton1 option").sort(function (a,b) { return a.value.toUpperCase().localeCompare(b.value.toUpperCase()) });
    $("#viewButton1").append(opt);
});

</script>

<?php
	## save the commentstarget
	if(!empty($_POST['data']) and !empty($_POST['filepath'])){
	$data = $_POST['data'];
	$fname = $_POST['filepath'];
	$file = fopen($fname, 'w');//creates new file
	$today = date("d/m/Y");
	fwrite($file, $data."\n");
	fclose($file);
	}
?>


<script type="text/javascript" src="js/JSmol.min.js"></script>
<script type="text/javascript">
	var Info = {
		width: 500,
		height: 300,
		serverURL: "http://chemapps.stolaf.edu/jmol/jsmol/jsmol.php ",
		use: "HTML5",
		j2sPath: "js/j2s"
	}
</script>
		
<body style="overflow-x=hidden">
    <div id="header">
<!--        <h1 id="title">CASP13</h1>-->
        <!--<h2 id="subtitle">Critical Assesment of Techniques for Protein Structure Prediction</h2>-->
<!--        <h2 id="subtitle">Central Web Portal of MULTICOM Predictors</h2>-->
    </div>
    <div class="post_success">
        <div class="visualization-container">
          <div class="row"> <!-- row for visualization container -->
            <div class="col-md-5">
                <div class="dropdown col-md-3 text-left">
                    <button id="dropdown-description" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo strToUpper($method_id) ?><span class="caret"></span></button>
                    <select  class="dropdown-menu" id="title-menu" multiple="multiple" aria-labelledby="targetMenu" style="left: 19px; min-width: 111px; overlfow-y: auto;">
							<?php
                    
							if ($handle = opendir('MULTICOM_Methods/')) {
								$blacklist = array('.', '..','comments.txt');
								while (false !== ($file = readdir($handle))) {
									if (!in_array($file, $blacklist)) {
										$file = rtrim($file);
										$file_upper=strtoupper($file);
										echo "<option class='dropdown-menu-methods'><button id=\"#$file\" type=\"button\"  value=\"$file\">$file</button></option>\n";
									}
								}
								closedir($handle);
							}
							?>
						
                    </select >
				</div>
<?php if($method_id == 'multicom' or $method_id == 'confold2'  or $method_id == 'deepsf')
{ ?> 
		<div class="dropdown col-md-2 text-left">
				    <button class="btn btn-default dropdown-toggle" type="button" id="targetMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					
							Please select the target
							<span class="caret"></span>
				    </button>
					
				    <ul class="dropdown-menu" id="view_targets" multiple="multiple" aria-labelledby="targetMenu" size=20 style="left: 19px; font-size: 15px; min-width: 133px;">
							<?php
								if ($handle = opendir("MULTICOM_Methods/$method_id")) {
									$blacklist = array('.', '..','comments.txt');
									while (false !== ($file = readdir($handle))) {
										if (!in_array($file, $blacklist) and is_dir("MULTICOM_Methods/$method_id/$file") and strlen($file)>10) {
											$file = rtrim($file);
                                            $subStr = substr($file, 0, 10);
											echo "<li><button id=\"#$file\" type=\"button\"  class='target-btns btn' style='margin-bottom: 4px;' value=\"$file\" onclick='loadTarget(this)' >$file</button></li>\n";
										}
									}
									closedir($handle);
								}
								?>
				    </ul>
                  <div class="loader" id="multi_confold_deep_loader" style="display:none;"></div>
				</div>
                <div id="visualization">
				    <div class="col-md-4 method_box">
                        <!--   script to load visualization  -->
					   <script type="text/javascript">
								var model = 1;
								var rfile = 1;
								var ifile = 2;
								var append = "APPEND";
								Jmol.getApplet("jsmolAppletM1", Info);
						
								Jmol.script(jsmolAppletM1,"background black;");
								Jmol.script(jsmolAppletM1, "spin on; cartoon only; color {file=1} group;");
								Jmol.jmolCheckbox(jsmolAppletM1,"","","Top1 Structure", false, "initialCheck");
								Jmol.jmolCheckbox(jsmolAppletM1,"","","Selected Structure", true, "refinedCheck");
								var methodName="";
								var target="";
								$(document).ready(function() {
									$("#view_targets").click(function() {
                                        document.getElementById("multi_confold_deep_loader").style.display = "inline-block";
										methodName = $("#dropdown-description").text();
                                        target = getTarget();
										target = target.replace(/\n/g, '');
                                        
										model = 1;
										if ($("#refinedCheck").prop("checked")) {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											if (!$("#initialCheck").prop("checked")) append = "";
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file=1} group;");
										}
										else {
											$("#refinedCheck").prop("checked", true);
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file=1} group;");
										}
										append = "APPEND";
										$("#modelTitle").html("Predicted Model 1");
                                      hideLoader();
									});
                                  
                                    function hideLoader(){
                                      document.getElementById("multi_confold_deep_loader").style.display = "none";
                                    }
                                  
									$("#viewButton1").click(function() {
										methodName = $("#dropdown-description").text();
										target = String($(this).val());
										target = target.replace(/\n/g, '');
										model = 1;
										if ($("#refinedCheck").prop("checked")) {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											if (!$("#initialCheck").prop("checked")) append = "";
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										else {
											$("#refinedCheck").prop("checked", true);
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										append = "APPEND";
										$("#modelTitle").html("Predicted Model 1");
									});
									$("#viewButton2").click(function() {
										methodName = $("#dropdown-description").text();
										target = String($(this).val());
										target = target.replace(/\n/g, '');
										model = 2;
										if ($("#refinedCheck").prop("checked")) {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											if (!$("#initialCheck").prop("checked")) append = "";
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										else {
											$("#refinedCheck").prop("checked", true);
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										append = "APPEND";
										$("#modelTitle").html("Predicted Model 2");
									});
									$("#viewButton3").click(function() {
										methodName = $("#dropdown-description").text();
										target = String($(this).val());
										target = target.replace(/\n/g, '');
										model = 3;
										if ($("#refinedCheck").prop("checked")) {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											if (!$("#initialCheck").prop("checked")) append = "";
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										else {
											$("#refinedCheck").prop("checked", true);
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										append = "APPEND";
										$("#modelTitle").html("Predicted Model 3");
									});
									$("#viewButton4").click(function() {
										methodName = $("#dropdown-description").text();
										target = String($(this).val());
										target = target.replace(/\n/g, '');
										model = 4;
										if ($("#refinedCheck").prop("checked")) {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											if (!$("#initialCheck").prop("checked")) append = "";
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										else {
											$("#refinedCheck").prop("checked", true);
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										append = "APPEND";
										$("#modelTitle").html("Predicted Model 4");
									});
									$("#viewButton5").click(function() {
										methodName = $("#dropdown-description").text();
										target = String($(this).val());
										target = target.replace(/\n/g, '');
										model = 5;
										if ($("#refinedCheck").prop("checked")) {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											if (!$("#initialCheck").prop("checked")) append = "";
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										else {
											$("#refinedCheck").prop("checked", true);
											rfile = $("#initialCheck").prop("checked") ? ifile+1: 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										append = "APPEND";
										$("#modelTitle").html("Predicted Model 5");
									});
									
									$("#refinedCheck").click(function() {
										if(this.checked) {
											rfile = $("#initialCheck").prop("checked") ? ifile+1 : 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb;");
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ rfile+"} group;");
											append = "APPEND";
										}
										else {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											if (!$("#initialCheck").prop("checked")) append = "";
										}
									});
									$("#initialCheck").click(function() {
										if(this.checked) {
											ifile = $("#refinedCheck").prop("checked") ? rfile+1 : 1;
											Jmol.script(jsmolAppletM1,"load "+append+" MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model1.pdb;');
											Jmol.script(jsmolAppletM1, "frame ALL; spin on; cartoon only; color {file="+ ifile+"} white;");
											append = "APPEND";
										}
										else {
											Jmol.script(jsmolAppletM1, "zap file=" + ifile + ";");
											if (!$("#refinedCheck").prop("checked")) append = "";
										}
									});
									
									//presort table
									var thID = 0;
									<?php if ($rwp && $molp) { ?> thID = 6;
									<?php } else if ($rwp) { ?> thID = 5;
									<?php } else if ($molp) { ?> thID = 5;
									<?php } else { ?> thID = 1; <?php } ?> 
									var myTH = document.getElementsByTagName("th")[thID];
									sorttable.innerSortFunction.apply(myTH, []);	
								});
							</script>
                  </div>
                </div> <!-- end of visualization -->
                <!--save new comments -->
                <script>
                    function saveNewComment(commentId, box, filepath) {
                        var newComment = document.getElementById(commentId).value;
                        var method = $("#dropdown-description").text().toLowerCase();
                        $.post("updateComments.php", {newComment: newComment, method: method, filepath: filepath}, function(response){
                            document.getElementById(box).value = response;
                            document.getElementById('newComment').value = '';
                        });
                    }
                </script>
				<div class="col-md-10">
						<font size="5"><b>Comments</b></font>
						<?php if ($method_id == 'deepsf' || 'multicom' || 'confold2'){ ?>
				        <textarea readonly id="comment_box" style="height:200px; width: 100%; overflow-y:auto; resize: none;" class="comment_content"><?php echo trim(file_get_contents("./MULTICOM_Methods/$method_id/comments.txt", true));?></textarea><br>
                    <div style="margin-top: 5px; display: block; text-align:center;">
                    <textarea id="newComment" name=newComment style="width:86%; height:30px; resize: none;" placeholder="New Comment"></textarea>
                    
                        <input type="button" class="btn" value="Save" style="vertical-align: 11px; padding: 5px;" id="<?php echo $method_id ?>_comment" onclick="saveNewComment('newComment','comment_box','./MULTICOM_Methods/<?php echo $method_id ?>/comments.txt')"/>
                      </div>
						<?php }else if($method_id == 'dncon2'){ ?>
								<textarea  id="comment_box" rows="4" cols="50" class="comment_content"></textarea><br>
								<input type="button" value="save my comments" onclick="saveNewComment('newComment','comment_box','./MULTICOM_Methods/<?php $method_id ?>/comments.txt')"/>  
						<?php }else{?>
								<textarea  rows="4" cols="50">  <?php echo "";?> </textarea><br>
						<?php }?>
				</div> 
          </div> <!-- end of col-md-5 --> 
<?php
}
?>
<?php
if ($method_id == 'multicom' or $method_id == 'deepsf')
{
?>
        <div class="col-md-7 update-box">
               <div id="displayTableCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                  <ol class="carousel-indicators">
                  <li data-target="#displayTableCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#displayTableCarousel" data-slide-to="1"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="item active" style="height:352px; margin-left: 12%;">
						<div class="table col-md-3 method_box">
							<table id="myTable" class="" style="margin-top:13px;">
								<thead>
								<tr>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">Model #</th>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">View Model</th>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">Align</th>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">Contact</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_1" href="">Top_1</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton1" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewAlign1" value="" onclick="openPopup('viewAlign1');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis1" value="" >Run</button></td>
								
								</tr>
								<tr>	
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_2" href="">Top_2</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton2" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewAlign2" value="" onclick="openPopup('viewAlign2');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis2" value="" >Run</button></td>
							
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class=" view_model" id="view_model_3" href="">Top_3</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton3" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewAlign3" value="" onclick="openPopup('viewAlign3');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis3" value=""  >Run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_4" href="">Top_4</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton4" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewAlign4" value="" onclick="openPopup('viewAlign4');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis4" value="" >Run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class=" view_model" id="view_model_5" href="">Top_5</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton5" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewAlign5" value="" onclick="openPopup('viewAlign5');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis5" value="" >Run</button></td>
								</tr>
								</tbody>
							</table>
						</div>
<?php
if ($method_id == 'multicom' || 'deepsf')
{
?>
                  <div class="col-md-5">
		            <h3> Model evaluation: </h3>
		            <div style="height:auto; border-style: solid; border-width: medium; width: fit-content; overflow-y: auto; overflow-x: auto;"> 
				      <table style="border-collapse: collapse; border: 1px solid black;text-align:center;font-family: arial;" id="model_evaluation" ></table>
                    </div>
                  </div>
<?php
}
?>
<?php
if ($method_id == 'deepsf')
{
?>
                  <div class="col-md-5">
                      		<h3 > Fold alignment: </h3>
			<div style="width: 800px; height: 400px; float:left;">
              <a href="./">
                <img style="width: 800px; height: 400px; margin: 0 auto;text-align: center;" alt="DeepSF" src="" id="deepsf_fold_image"/>
              </a>
            </div>
                      </div>
<?php
}
?>

             </div> <!-- end of carousel item 1 -->
<?php
}
?>
                    
<?php
if ($method_id == 'confold2')
{
?>
             <div class="col-md-7 update-box">
               <div id="displayTableCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                 <ol class="carousel-indicators">
                  <li data-target="#displayTableCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#displayTableCarousel" data-slide-to="1"></li>
                 </ol>
                 <div class="carousel-inner" style="height:600px; margin-left: 12%;">
                   <div class="item active" style="height:502px;">
                     <div class="col-md-3" style="margin-top: 10%;">
						<div class="table method_box">
							<table id="myTable" class="sortable" style="margin-top:13px;">
								<thead>
								<tr>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">Model #</th>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">View Model</th>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">Contact</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_1" href="">Top_1</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton1" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis1" value="" >Run</button></td>
								
								</tr>
								<tr>	
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_2" href="">Top_2</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton2" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis2" value="" >Run</button></td>
							
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_3" href="">Top_3</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton3" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis3" value=""  >Run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_4" href="">Top_4</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton4" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis4" value="" >Run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><h4><a class="view_model" id="view_model_5" href="">Top_5</a></h4></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="viewButton5" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" class="btn btn-table" id="pdb_contact_analysis5" value="" >Run</button></td>
								</tr>
								</tbody>
							</table>
                        </div>
                      </div>
						<div class="col-md-5">
                        <h3> Predicted Contacts: </h3>
				        <div style="width:fit-content;"> 
				            <textarea style="height:480px; overflow-y:auto; border: solid black medium;" readonly rows="150" cols="50" id="confold_contact" ></textarea>
                        </div>
                      </div>	
				    </div> <!-- end of carousel item-->
                    <div class='carousel item'>
                      <div style="width:fit-content; margin-left: 10%; ">
				        <h3 style="text-align: center;"> Predicted Contact Map: </h3>
				        <div style="width: 480px; height: auto;">
                          <img style="width: 480px; height: 480px; margin: 0 auto;text-align: center;" alt="DeepSF" src="" id="confold_contact_map"/>
                        </div>
                     </div>
				  </div> <!-- end of carousel item 2-->
              </div> <!--  end of carousel-inner role listbox -->
              <a class="left carousel-control" href="#displayTableCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#displayTableCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
        </div> <!-- end of carousel -->
    </div> <!-- end of update-box -->

<?php
}
?>
			
<?php if($method_id == 'dncon2')
{ ?>
				<div class="col-md-9">
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Please select the target
							<span class="caret"></span>
						</button>
						<select class="dropdown-menu" id="dncon2_run" multiple="multiple" aria-labelledby="dropdownMenu1" size=20>
							<?php
								
								if ($handle = opendir("MULTICOM_Methods/$method_id")) {
									$blacklist = array('.', '..','comments.txt');
									while (false !== ($file = readdir($handle))) {
										if (!in_array($file, $blacklist) and strpos($file, '.rr') !== false and strpos($file, '_full') !== false) {
											$file = rtrim($file);
											echo "<option><button id=\"#$file\" type=\"button\"  value=\"$file\">$file</button></option>\n";
										}
									}
									closedir($handle);
								}
								?>
						</select >
                        <div class="loader" id="dncon2_iframe_loader" style="display:none;"></div> <!-- loading icon -->
					</div>
				</div>
				<div  style="height: 500px; width: 1200px;border: 0px solid black;" >
					<iframe id="dncon2_iframe" src=""  width="100%"  height="100%" style="border:none;"></iframe><br/>
				</div>

<?php  } ?>
			
<?php if($method_id == 'deepsf1')
{ ?>
				<div class="col-md-1">
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="targetMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Please select the target (need 1~5 seconds to load)
							<span class="caret"></span>
						</button>
					
						<select class="dropdown-menu" id="deepsf_run" multiple="multiple" aria-labelledby="targetMenu" size=20>
							<?php
								
								if ($handle = opendir("MULTICOM_Methods/$method_id")) {
									$blacklist = array('.', '..','comments.txt');
									while (false !== ($file = readdir($handle))) {
										if (!in_array($file, $blacklist) and strpos($file, '@') !== false) {
											$file = rtrim($file);
											echo "<option><button id=\"#$file\" type=\"button\"  value=\"$file\">$file</button></option>\n";
										}
									}
									closedir($handle);
								}
								?>
						</select >
					</div>
				</div>
				<div  style="height: 500px; width: 1200px;border: 0px solid black;">
					<iframe id="deepsf_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
				</div>
<?php  } ?>
<?php if ($method_id == 'multicom')
{ ?>
            <div class="item" style="height:300px;">       
            <div style="text-align:center;">
              <h3 > Protein sequence: </h3>
              <textarea  readonly="readonly" cols="80" rows="10" id="protein_sequence"></textarea>
            </div>
            </div> <!-- end of carousel item 2 -->

                </div> <!-- end of carousel-inner role listbox -->
                <a class="left carousel-control" href="#displayTableCarousel" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#displayTableCarousel" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div> <!-- end of carousel -->
            </div> <!-- end of update-box -->
<?php } ?>
<?php
if ($method_id == 'multicom')
{
?>
          <div class="row">
            <div style="display: inline-block; margin-left: -11%;">
				<h3 > Template Rank list: </h3>
				<div style="height:300px;border-style: solid;border-width: medium; width: fit-content; overflow-y: auto; overflow-x: auto;"> 
				  <table style="border-collapse: collapse; border: 1px solid black;text-align:center;font-family: arial;" id="template_rank" >
				  </table>
                </div>
              </div>
          </div> <!-- end row -->
<?php
}
?>
		</div> <!-- end of the row with the visualization container -->		

<?php
if ($method_id == 'deepsf')
{
?>
    <div class="row">
        <h2 align="center"> Summary of DeepSF prediction: </h2>
        <input type="hidden" value="" id="deepsf_web_prediction_jobname"/>
        <input type="hidden" value="" id="deepsf_web_prediction_jobid"/>
        <div  style="height: 1000px; width: 1600px;border: 0px solid black;margin:0 auto;" align="center">
            <iframe id="deepsf_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
        </div>
				
        <h2 align="center"> Contact analysis (need 10 seconds to load): </h2>
        <div  style="height: 1000px; width: 1200px;border: 0px solid black;margin:0 auto; " >
            <iframe id="pdb_contact_analysis_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
        </div>
    </div>	
    </div> <!-- end of visualiation containter -->
<?php
}
?>	
<?php
if ($method_id == 'multicom' or $method_id == 'confold2')
{
?>
    <div class="row">
       <h2 align="center"> Contact analysis (need 10 seconds to load): </h2>
        <div  style="height: 1000px; width: 1200px;border: 0px solid black;margin:0 auto;" >
            <iframe id="pdb_contact_analysis_iframe" src=""  width="100%"  height="10%" ></iframe><br/>
        </div>
    </div>	
    
    </div> <!-- end of visualiation containter -->
          
<?php
}
?>	
<?php
if ($method_id == 'multicom')
{ ?>
<script type="text/javascript">
    // this must be in the last, otherwise, the document won't be load
	function intial_load() {
           var methodName = 'multicom';
			var target = '2017-11-04_00000042_1_50';
			target = target.replace(/\n/g, '');
			model = 1;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			document.getElementById('viewAlign1').value =aln_file;
		  
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			document.getElementById('viewAlign5').value =aln_file;
			
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('protein_sequence').value = data;
			});
          
			//  load the protein template rank
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash';
            console.log(methodName.toLocaleLowerCase());
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
                console.log("This was the data ; " + data);
				document.getElementById('template_rank').value =data;
			});
			
//          
//		   //alert(document.getElementById('multicom_comment').onclick);
//		   document.getElementById('multicom_comment').setAttribute( "onClick", "saveEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
//		   document.getElementById('multicom_comment_add').setAttribute( "onClick", "addEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
//		   document.getElementById('multicom_comment_refresh').setAttribute( "onClick", "refreshEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
//		   
		   
		   
		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
			var client = new XMLHttpRequest();
			client.open('GET', comment_file);
			jQuery.get(comment_file, function(data) {
				document.getElementById("edit_comment2").readOnly = true;
				document.getElementById('edit_comment2').value =data;
				document.getElementById('edit_comment2').scrollTop=document.getElementById('edit_comment2').scrollHeight;
			});
			
			
			
			// update the rank list 
			var dashfile = "MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash.csv';
			
			client.open('GET', dashfile);
			
			
			jQuery.get(dashfile, function(data) {
				var lines = data.split('\n');
				var tableContent = '<tbody>';
				for(var line = 0; line < lines.length; line++){
				//for(var line = 0; line < 2; line++){
					var line_array = lines[line].split(',');
					tableContent += '<tr style="border: 1px solid black;">';
					for(var ind = 0; ind < line_array.length; ind++){
						tableContent += '<td style="border: 1px solid black;padding: 6px;">'+line_array[ind]+'</td>';
					}
					tableContent += '</tr>';
				}
				tableContent += '</tbody>';
				$('#template_rank').html(tableContent);
			});
      
      
		// update the rank list 
		var modelevafile = "MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/model.evaluation';
      
        $.get(modelevafile)
			.done(function() { 
				// exists code 
				var client = new XMLHttpRequest();
				client.open('GET', modelevafile);
				jQuery.get(modelevafile, function(data) {
					var lines = data.split('\n');
					var tableContent = '<tbody>';
					for(var line = 0; line < lines.length; line++){
					//for(var line = 0; line < 2; line++){
						var line_array = lines[line].split('\t');
						tableContent += '<tr style="border: 1px solid black;">';
						for(var ind = 1; ind < line_array.length; ind++){
							tableContent += '<td style="border: 1px solid black;padding: 6px;">'+line_array[ind]+'</td>';
						}
						tableContent += '</tr>';
					}
					tableContent += '</tbody>';
					$('#model_evaluation').html(tableContent);
				});
			}).fail(function() {
                console.log(modelevafile);
                console.log("THIS WAS A FAILURE");
				// not exists code
			});
		}
	window.onload = intial_load();	
</script>

<?php
}
?>	


<?php
if ($method_id == 'deepsf')
{	
?>
<script type="text/javascript">
    // this must be in the last, otherwise, the document won't be load
	function intial_load() {
           var methodName = 'deepsf';
			var target = '2017-10-14_00000088_1_71';
			target = target.replace(/\n/g, '');
			model = 1;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			document.getElementById('viewAlign1').value =aln_file;
		  
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/juliaCASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			document.getElementById('viewAlign5').value =aln_file;
			
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/juliaCASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('protein_sequence').value =data;
			});
          
			 
		   // update the deepsf prediction link 
		   
		   //deepsf_web_prediction
		   
		   var deepsf_info = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".info";
		   //alert(deepsf_info);
			
			var client = new XMLHttpRequest();
			client.open('GET', deepsf_info);
			jQuery.get(deepsf_info, function(data) {
				var lines = data.split('\n');
				var deepsf_jobname = lines[1];
				var deepsf_id = lines[3];
				document.getElementById('deepsf_web_prediction_jobid').value =deepsf_id;
				document.getElementById('deepsf_web_prediction_jobname').value =deepsf_jobname;
					
			   //alert("http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+deepsf_jobname+"&protein_id="+deepsf_jobname);
			   document.getElementById('deepsf_iframe').src = "http://iris.rnet.missouri.edu/DeepSF/status.php?job_id="+deepsf_id+"&job_name="+deepsf_jobname+"&protein_id="+deepsf_jobname;
			   document.getElementById('deepsf_iframe').width = "100%";
			   document.getElementById('deepsf_iframe').height = "100%";
			});
			//load fold image
			var contact_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model1.foldmarker.jpeg';
			document.getElementById('deepsf_fold_image').src =contact_file_map;
          
		   //alert(document.getElementById('multicom_comment').onclick);
		   document.getElementById('multicom_comment').setAttribute( "onClick", "saveEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_add').setAttribute( "onClick", "addEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_refresh').setAttribute( "onClick", "refreshEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   
		   
		   
		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
			var client = new XMLHttpRequest();
			client.open('GET', comment_file);
			jQuery.get(comment_file, function(data) {
				document.getElementById("edit_comment2").readOnly = true;
				document.getElementById('edit_comment2').value =data;
				document.getElementById('edit_comment2').scrollTop=document.getElementById('edit_comment2').scrollHeight;
			});
			
		}
	window.onload = intial_load();	
</script>

<?php
}
?>	


<?php
if ($method_id == 'confold2')
{	
?>
<script type="text/javascript">
    // this must be in the last, otherwise, the document won't be load
	function intial_load() {
           var methodName = 'confold2';
			var target = '2017-11-04_00000045_2_71';
			target = target.replace(/\n/g, '');
			model = 1;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			//document.getElementById('viewAlign1').value =aln_file;
		  
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			//document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			//document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			//document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			//document.getElementById('viewAlign5').value =aln_file;
			
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('protein_sequence').value =data;
			});
          
			//  load the protein template rank
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash';
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('template_rank').value =data;
			});
			
			
			var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.rr';
			var client = new XMLHttpRequest();
			client.open('GET', contact_file);
			jQuery.get(contact_file, function(data) {
				document.getElementById('confold_contact').value =data; 
			});
			
			
			//load contact map
			var contact_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.cmap.png';
			document.getElementById('confold_contact_map').src =contact_file_map;
          
		   //alert(document.getElementById('multicom_comment').onclick);
		   document.getElementById('multicom_comment').setAttribute( "onClick", "saveEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_add').setAttribute( "onClick", "addEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_refresh').setAttribute( "onClick", "refreshEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   
		   
		   
		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/julia/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
			var client = new XMLHttpRequest();
			client.open('GET', comment_file);
			jQuery.get(comment_file, function(data) {
				document.getElementById("edit_comment2").readOnly = true;
				document.getElementById('edit_comment2').value =data;
				document.getElementById('edit_comment2').scrollTop=document.getElementById('edit_comment2').scrollHeight;
			});
			
			
			
			// update the rank list 
			var dashfile = "MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash.csv';
			var client = new XMLHttpRequest();
			client.open('GET', dashfile);
			jQuery.get(dashfile, function(data) {
				var lines = data.split('\n');
				var tableContent = '<tbody>';
				for(var line = 0; line < lines.length; line++){
				//for(var line = 0; line < 2; line++){
					var line_array = lines[line].split(',');
					tableContent += '<tr style="border: 1px solid black;">';
					for(var ind = 0; ind < line_array.length; ind++){
						tableContent += '<td style="border: 1px solid black;padding: 6px;">'+line_array[ind]+'</td>';
					}
					tableContent += '</tr>';
				}
				tableContent += '</tbody>';
				$('#template_rank').html(tableContent);
			});
		}
	window.onload = intial_load();	
</script>

<?php
}
?>	

</body>
</html>