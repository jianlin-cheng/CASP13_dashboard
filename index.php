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
</head>

<script type="text/javascript">
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function saveEdits(formid,updateid, filepath) { 
	//get the editable element
	var editElem = document.getElementById(formid).value;
	var data = new FormData();
	data.append("data" , editElem);
	data.append("filepath" , filepath);
	var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
	xhr.open( 'post', 'http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard//index.php', true );
	xhr.send(data);
	sleep(5000); // 1000 for 1 seconds
	// display the updated comments
	//alert('saved to '+filepath);
	$.get(filepath)
	.done(function() { 
		// exists code 
		var client = new XMLHttpRequest();
		client.open('GET', filepath,true);
		jQuery.get(filepath, function(data) {
			document.getElementById(formid).value=data;
			document.getElementById(formid).scrollTop=document.getElementById(formid).scrollHeight;
			document.getElementById(formid).readOnly = true;
			document.getElementById('multicom_comment_add').style.display = 'inline';
			document.getElementById('multicom_comment').style.display = 'none';
		})
	}).fail(function() { 
		// not exists code
			document.getElementById(formid).scrollTop=document.getElementById(formid).scrollHeight;
			document.getElementById(formid).readOnly = true;
			document.getElementById('multicom_comment_add').style.display = 'inline';
			document.getElementById('multicom_comment').style.display = 'none';
	})
	

	//write a confirmation to the user
	if(document.getElementById(updateid))
	{
		document.getElementById(updateid).innerHTML="Edits saved!";
	}
}

function refreshEdits(formid,updateid, filepath) { 
	
	//alert(filepath);
	$.get(filepath)
	.done(function() { 
		// exists code 
		var client = new XMLHttpRequest();
		client.open('GET', filepath,true);
		jQuery.get(filepath, function(data) {
			//alert(data);
			document.getElementById(formid).value=data;
			document.getElementById(formid).scrollTop=document.getElementById(formid).scrollHeight;
			document.getElementById(formid).readOnly = true;
		})
	}).fail(function() { 
		// not exists code
			document.getElementById(formid).scrollTop=document.getElementById(formid).scrollHeight;
			document.getElementById(formid).readOnly = true;
			document.getElementById('multicom_comment_add').style.display = 'inline';
			document.getElementById('multicom_comment').style.display = 'none';
	})
	
	//write a confirmation to the user
	if(document.getElementById(updateid))
	{
		document.getElementById(updateid).innerHTML="Comments updated!";
	}
}


function addEdits(formid,updateid, filepath) { 
	var client = new XMLHttpRequest();
	var dateObj = new Date();
	var minute = dateObj.getMinutes();
	var hour = dateObj.getHours(); 
	var month = dateObj.getUTCMonth() + 1; //months from 1-12
	var day = dateObj.getUTCDate();
	var year = dateObj.getUTCFullYear();
	//alert(filepath);
	newdate = "[ "+year + "-" + month + "-" + day + " " + hour + ":" + minute + "] ";
	$.get(filepath)
	.done(function() { 
		// exists code 
		var client = new XMLHttpRequest();
		client.open('GET', filepath,true);
		jQuery.get(filepath, function(data) {
			document.getElementById(formid).readOnly = false;
			document.getElementById(formid).value=data +""+newdate + ": ";
			document.getElementById(formid).scrollTop=document.getElementById(formid).scrollHeight;
			document.getElementById('multicom_comment_add').style.display = 'none';
			document.getElementById('multicom_comment').style.display = 'inline';
		});
	}).fail(function() { 
		// not exists code
		//alert('No comments yet!');
		document.getElementById("edit_comment2").readOnly = false;
		document.getElementById(formid).value=newdate + ": ";
		document.getElementById('multicom_comment_add').style.display = 'none';
		document.getElementById('multicom_comment').style.display = 'inline';
	})
	
	
}
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
	

/*    
    $(document).ready(function() {
       $("#title-menu").click(function() {
           var target = String($(this).val());
           $("#dropdown-description").html(target.toUpperCase() + '<span class="caret"></span>');
            $.get("updateMethod.php", {method:target}, function(response){
                console.log("This was the response " + response);
                $("#viewButton1").html(response);
                });
           $(".comment_box").html(target.toUpperCase() + " Comment Box");
           $(".comment_content").html( "\<\?php echo trim(file_get_contents(\'./MULTICOM_Methods/"+target+"/comments.txt\', true));?>");
            });
    });
*/
    $(document).ready(function() {
       $("#title-menu").click(function() {
           var target = String($(this).val());
           $("#dropdown-description").html(target.toUpperCase() + '<span class="caret"></span>');
            $.get("updateMethod.php", {method:target}, function(response){
                console.log("This was the response " + response);
                $("#viewButton1").html(response);
                });
           $(".comment_box").html(target.toUpperCase() + " Comment Box");
           location.href = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/index.php?method=" + target;
            });
    });
	
    $(document).ready(function() {
       $("#view_targets").click(function() {
           var methodName = $("#dropdown-description").text();
			var target = String($(this).val());
			target = target.replace(/\n/g, '');
			model = 1;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			document.getElementById('viewAlign1').value =aln_file;
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			document.getElementById('viewAlign5').value =aln_file;
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			
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
			var fasta_rank = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash';
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
			var deepsf_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model1.foldmarker.jpeg';
			if(document.getElementById('deepsf_fold_image'))
			{
				document.getElementById('deepsf_fold_image').src = deepsf_file_map;
			}
			
			
			//alert('here');
			//  load the protein predicted contact
			var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.rr';

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
			var contact_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.cmap.png';
			if(document.getElementById('confold_contact_map'))
			{
				document.getElementById('confold_contact_map').src =contact_file_map;
			}
		    //alert('yes');
			
		   //alert(document.getElementById('multicom_comment').onclick);
		   document.getElementById('multicom_comment').setAttribute( "onClick", "saveEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_add').setAttribute( "onClick", "addEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_refresh').setAttribute( "onClick", "refreshEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   

		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
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
			var dashfile = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash.csv';
			
			
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
		   var deepsf_info = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".info";
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
           var target = String($(this).val());
		   var array_tmp = target.split('.');
		   var targetname=array_tmp[0];
		   //alert(target);
		   //alert(targetname);
		   //alert("http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw=http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard//MULTICOM_Methods/dncon2/"+target+"&job_id="+targetname);
           document.getElementById('dncon2_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw=http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard//MULTICOM_Methods/dncon2/"+target+"&job_id="+targetname;
           document.getElementById('dncon2_iframe').width = "100%";
           document.getElementById('dncon2_iframe').height = "100%";
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
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
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
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
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
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
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
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
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
		  
		    var model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+targetname+'/'+targetname+'_model'+model+ ".pdb";
		    var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/confold2/"+targetname_confold+'/'+targetname_confold+'.rr';
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

$(document).ready(function() {
    var opt = $("#viewButton1 option").sort(function (a,b) { return a.value.toUpperCase().localeCompare(b.value.toUpperCase()) });
    $("#viewButton1").append(opt);
});

</script>

<?php
	## save the comments
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
		
	

	
<body onload="checkEdits()">
    <div id="header">
        <h1 id="title">CASP13</h1>
        <!--<h2 id="subtitle">Critical Assesment of Techniques for Protein Structure Prediction</h2>-->
        <h2 id="subtitle">Central Web Portal of MULTICOM Predictors</h2>
    </div>
    <div class="post_success">
        <div class="visualization-container">
            <div class="col-md-6">
                <div class="dropdown col-md-3 text-left">
                    <button id="dropdown-description" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo strToUpper($method_id) ?><span class="caret"></span></button>
                    <select  class="dropdown-menu" id="title-menu" multiple="multiple" aria-labelledby="dropdownMenu1" size=10>
							<?php
                    
							if ($handle = opendir('MULTICOM_Methods/')) {
								$blacklist = array('.', '..','comments.txt');
								while (false !== ($file = readdir($handle))) {
									if (!in_array($file, $blacklist)) {
										$file = rtrim($file);
										$file_upper=strtoupper($file);
										echo "<option><button id=\"#$file\" type=\"button\"  value=\"$file\">$file</button></option>\n";
									}
								}
								closedir($handle);
							}
							?>
						
                    </select >
				</div>
			<?php if($method_id == 'multicom' or $method_id == 'confold2'  or $method_id == 'deepsf'){ ?> 
				<div class="dropdown col-md-2 text-left">
				    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					
							Please select the target
							<span class="caret"></span>
				    </button>
					
				    <select class="dropdown-menu dropdown-menu-center" id="view_targets" multiple="multiple" aria-labelledby="dropdownMenu1" size=20>
							<?php
								if ($handle = opendir("MULTICOM_Methods/$method_id")) {
									$blacklist = array('.', '..','comments.txt');
									while (false !== ($file = readdir($handle))) {
										if (!in_array($file, $blacklist) and is_dir("MULTICOM_Methods/$method_id/$file") and strlen($file)>10) {
											$file = rtrim($file);
											echo "<option><button id=\"#$file\" type=\"button\"  value=\"$file\">$file</button></option>\n";
										}
									}
									closedir($handle);
								}
								?>
				    </select>
				</div>
                <div class="row" id="visualization">
				    <div class="col-md-4 method_box">
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
										methodName = $("#dropdown-description").text();
										console.log("This is the method name " + methodName);
										target = String($(this).val());
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
									});
									$("#viewButton1").click(function() {
										methodName = $("#dropdown-description").text();
										console.log("This is the method name " + methodName);
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
										console.log("This is the method name " + methodName);
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
										console.log("This is the method name " + methodName);
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
										console.log("This is the method name " + methodName);
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
										console.log("This is the method name " + methodName);
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
				<div class="col-md-4 method_box">
						<font size="5"><b>Comment Box</b></font>
						<?php if ($method_id == 'multicom'){ ?>
								<textarea  id="edit_comment2" rows="4" cols="50" class="comment_content"></textarea><br>
								<input type="button" value="Add" style="display:inline" id="multicom_comment_add" onclick="addEdits('edit_comment2','update2','./MULTICOM_Methods/multicom/comments.txt')"/>
								<input type="button" value="Save" style="display:none" id="multicom_comment" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/multicom/comments.txt')"/>
								<input type="button" value="Refresh" id="multicom_comment_refresh" onclick="refreshEdits('edit_comment2','update2','./MULTICOM_Methods/multicom/comments.txt')"/>
								<div id="update2"> - Edit the text and click to save for next time</div>
						<?php }else if($method_id == 'dncon2'){ ?>
								<textarea  id="edit_comment2" rows="4" cols="50" class="comment_content"></textarea><br>
								<input type="button" value="save my comments" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/dncon2/comments.txt')"/>
								<div id="update2"> - Edit the text and click to save for next time</div>
						<?php }else if($method_id == 'confold2'){?>
								<textarea  id="edit_comment2" rows="4" cols="50" class="comment_content"></textarea><br>
								<input type="button" value="Add" style="display:inline" id="multicom_comment_add" onclick="addEdits('edit_comment2','update2','./MULTICOM_Methods/confold2/comments.txt')"/>
								<input type="button" value="Save" style="display:none" id="multicom_comment" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/confold2/comments.txt')"/>
								<input type="button" value="Refresh" id="multicom_comment_refresh" onclick="refreshEdits('edit_comment2','update2','./MULTICOM_Methods/multicom/confold2.txt')"/>
								<div id="update2"> - Edit the text and click to save for next time</div>
						<?php }else if($method_id == 'deepsf'){?>
								<textarea  id="edit_comment2" rows="4" cols="50" class="comment_content"></textarea><br>
								<input type="button" value="Add" style="display:inline" id="multicom_comment_add" onclick="addEdits('edit_comment2','update2','./MULTICOM_Methods/deepsf/comments.txt')"/>
								<input type="button" value="Save" style="display:none" id="multicom_comment" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/deepsf/comments.txt')"/>
								<input type="button" value="Refresh" id="multicom_comment_refresh" onclick="refreshEdits('edit_comment2','update2','./MULTICOM_Methods/multicom/deepsf.txt')"/>
								<div id="update2"> - Edit the text and click to save for next time</div>
						<?php }else{?>
								<textarea  rows="4" cols="50">  <?php echo "";?> </textarea><br>
						<?php }?>
				</div> 
					</div>
<?php
if ($method_id == 'multicom' or $method_id == 'deepsf')
{
?>
						<div class="table col-md-8 method_box">
							<table id="myTable" class="sortable">
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
									<td style="border: 1px solid black;padding: 6px;"><a  id="view_model_1" href="">Top_1</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton1" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewAlign1" value="" onclick="openPopup('viewAlign1');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis1" value="" >run</button></td>
								
								</tr>
								<tr>	
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_2" href="">Top_2</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton2" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewAlign2" value="" onclick="openPopup('viewAlign2');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis2" value="" >run</button></td>
							
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_3" href="">Top_3</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton3" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewAlign3" value="" onclick="openPopup('viewAlign3');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis3" value=""  >run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_4" href="">Top_4</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton4" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewAlign4" value="" onclick="openPopup('viewAlign4');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis4" value="" >run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_5" href="">Top_5</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton5" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewAlign5" value="" onclick="openPopup('viewAlign5');" >View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis5" value="" >run</button></td>
								</tr>
								</tbody>
							</table>
							
							
						</div>	
<?php
}
?>
<?php
if ($method_id == 'confold2')
{
?>
						<div class="table col-md-8 method_box">
							<table id="myTable" class="sortable">
								<thead>
								<tr>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">Model #</th>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">View Model</th>
									<th style="border: 1px solid black;padding: 6px;" class="sorttable_nosort">Contact</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><a  id="view_model_1" href="">Top_1</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton1" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis1" value="" >run</button></td>
								
								</tr>
								<tr>	
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_2" href="">Top_2</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton2" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis2" value="" >run</button></td>
							
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_3" href="">Top_3</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton3" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis3" value=""  >run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_4" href="">Top_4</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton4" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis4" value="" >run</button></td>
								
								</tr>
								<tr>
									<td style="border: 1px solid black;padding: 6px;"><a id="view_model_5" href="">Top_5</a></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="viewButton5" value="">View</button></td>
									<td style="border: 1px solid black;padding: 6px;"><button type="button" id="pdb_contact_analysis5" value="" >run</button></td>
								</tr>
								</tbody>
							</table>
							
							
						</div>	
<?php
}
?>
			

			
			<?php  } ?>
			
			<?php if($method_id == 'dncon2'){ ?>
				<div class="col-md-1">
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Please select the target (need 1~5 seconds to load)
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
					</div>
				</div>
				<div  style="height: 500px; width: 1200px;border: 0px solid black; " >
					<iframe id="dncon2_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
				</div>
			<?php  } ?>
			
			<?php if($method_id == 'deepsf1'){ ?>
				<div class="col-md-1">
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Please select the target (need 1~5 seconds to load)
							<span class="caret"></span>
						</button>
					
						<select class="dropdown-menu" id="deepsf_run" multiple="multiple" aria-labelledby="dropdownMenu1" size=20>
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
               </div>
            </div> <!-- end of cold-md-6 -->
            
             <div class="update-box">
				<h3 > Protein sequence: </h3>
				<textarea  readonly="readonly" cols="80" rows="4" id="protein_sequence">Not load</textarea><br>
<?php
if ($method_id == 'multicom')
{
?>
				<h3 > Template Rank list: </h3>
				<div style="height:300px;overflow:auto;border-style: solid;border-width: medium;"  > 
				
				<table style="border-collapse: collapse; border: 1px solid black;text-align:center;font-family: arial;" id="template_rank" >
				</table>

				</div><br>

<?php
}else if ($method_id == 'confold2')
{
?>
				<h3 > Predicted Contacts: </h3>
				<div style="height:300px;overflow:auto;border-style: solid;border-width: medium;"  > 
				
				<textarea rows="50" cols="100" id="confold_contact" >
				</textarea>

				</div><br>
				
				<h3 > Predicted Contact Map: </h3>
				<div style="width: 480px; height: 480px; float:left;"><a href="./"><img style="width: 480px; height: 480px; margin: 0 auto;text-align: center;" alt="DeepSF" src="" id="confold_contact_map"/></a></div>

<?php
}else if ($method_id == 'deepsf')
{
?>
				
				<h3 > Fold alignment: </h3>
				<div style="width: 800px; height: 400px; float:left;"><a href="./"><img style="width: 800px; height: 400px; margin: 0 auto;text-align: center;" alt="DeepSF" src="" id="deepsf_fold_image"/></a></div>

	
<?php
}
?>

            <!--</div>
            <div class="functions col-md-4">
                <button class="btn btn-default">Function 1</button>    
                <button class="btn btn-default">Function 2</button>    
            </div>-->
				
        </div> <!-- end of visualiation containter -->
        
        
    </div>
	

<?php
if ($method_id == 'deepsf')
{
?>
				
				<h2 style="padding-top: 10em;" align="center"> Summary of DeepSF prediction: </h2>
				<input type="hidden" value="" id="deepsf_web_prediction_jobname"/>
				<input type="hidden" value="" id="deepsf_web_prediction_jobid"/>
				<div  style="height: 1000px; width: 1600px;border: 0px solid black;margin:0 auto;" align="center">
					<iframe id="deepsf_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
				</div>
				
				<h2 style="padding-top: 10em;" align="center"> Contact analysis (need 10 seconds to load): </h2>
				<div  style="height: 1000px; width: 1200px;border: 0px solid black;margin:0 auto; " >
					<iframe id="pdb_contact_analysis_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
				</div>
				
<?php
}
?>	
<?php
if ($method_id == 'multicom' or $method_id == 'confold2')
{
?>
				
				<h2 style="padding-top: 10em;" align="center"> Contact analysis (need 10 seconds to load): </h2>
				<div  style="height: 1000px; width: 1200px;border: 0px solid black;margin:0 auto;" >
					<iframe id="pdb_contact_analysis_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
				</div>
				
<?php
}
?>	


<?php
if ($method_id == 'multicom')
{
	
?>
<script type="text/javascript">
    // this must be in the last, otherwise, the document won't be load
	function intial_load() {
           var methodName = 'multicom';
			var target = '2017-11-04_00000042_1_50';
			target = target.replace(/\n/g, '');
			model = 1;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			document.getElementById('viewAlign1').value =aln_file;
		  
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			document.getElementById('viewAlign5').value =aln_file;
			
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('protein_sequence').value =data;
			});
          
			//  load the protein template rank
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash';
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('template_rank').value =data;
			});
			
          
		   //alert(document.getElementById('multicom_comment').onclick);
		   document.getElementById('multicom_comment').setAttribute( "onClick", "saveEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_add').setAttribute( "onClick", "addEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_refresh').setAttribute( "onClick", "refreshEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   
		   
		   
		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
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
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			document.getElementById('viewAlign1').value =aln_file;
		  
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			document.getElementById('viewAlign5').value =aln_file;
			
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('protein_sequence').value =data;
			});
          
			 
		   // update the deepsf prediction link 
		   
		   //deepsf_web_prediction
		   
		   var deepsf_info = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".info";
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
			var contact_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model1.foldmarker.jpeg';
			document.getElementById('deepsf_fold_image').src =contact_file_map;
          
		   //alert(document.getElementById('multicom_comment').onclick);
		   document.getElementById('multicom_comment').setAttribute( "onClick", "saveEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_add').setAttribute( "onClick", "addEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_refresh').setAttribute( "onClick", "refreshEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   
		   
		   
		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
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
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			
			document.getElementById('view_model_1').href =model_file;
			document.getElementById('viewButton1').value =target;
			document.getElementById('pdb_contact_analysis1').value =target+'.1';
			//document.getElementById('viewAlign1').value =aln_file;
		  
			model = 2;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
			document.getElementById('view_model_2').href =model_file;
			document.getElementById('viewButton2').value =target;
			document.getElementById('pdb_contact_analysis2').value =target+'.2';
			//document.getElementById('viewAlign2').value =aln_file;
          
		  
			model = 3;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_3').href =model_file;
			document.getElementById('viewButton3').value =target;
			document.getElementById('pdb_contact_analysis3').value =target+'.3';
			//document.getElementById('viewAlign3').value =aln_file;
          
		  
			model = 4;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
		    document.getElementById('view_model_4').href =model_file;
			document.getElementById('viewButton4').value =target;
			document.getElementById('pdb_contact_analysis4').value =target+'.4';
			//document.getElementById('viewAlign4').value =aln_file;
          
		  
		  
			model = 5;
			model_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pdb";
			aln_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'_model'+model+ ".pir";
            document.getElementById('view_model_5').href =model_file;
			document.getElementById('viewButton5').value =target;
			document.getElementById('pdb_contact_analysis5').value =target+'.5';
			//document.getElementById('viewAlign5').value =aln_file;
			
			
			//  load the protein sequence
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+ ".fasta";
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('protein_sequence').value =data;
			});
          
			//  load the protein template rank
			var fasta_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/full_length.dash';
			var client = new XMLHttpRequest();
			client.open('GET', fasta_file);
			jQuery.get(fasta_file, function(data) {
				document.getElementById('template_rank').value =data;
			});
			
			
			var contact_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.rr';
			var client = new XMLHttpRequest();
			client.open('GET', contact_file);
			jQuery.get(contact_file, function(data) {
				document.getElementById('confold_contact').value =data; 
			});
			
			
			//load contact map
			var contact_file_map = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/'+target+'.cmap.png';
			document.getElementById('confold_contact_map').src =contact_file_map;
          
		   //alert(document.getElementById('multicom_comment').onclick);
		   document.getElementById('multicom_comment').setAttribute( "onClick", "saveEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_add').setAttribute( "onClick", "addEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   document.getElementById('multicom_comment_refresh').setAttribute( "onClick", "refreshEdits('edit_comment2','update2','" + "./MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt'+"')");
		   
		   
		   
		    var comment_file = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+'/comments.txt';
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