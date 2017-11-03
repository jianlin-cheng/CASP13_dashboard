<?php
$method_id = $_REQUEST["method"];

if($method_id == 'dncon2')
{
	$method_id='dncon2';
}else if($method_id == 'confold2')
{
	$method_id='confold2';
}else{
	
	$method_id='multicom';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display 3 Methods</title>
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
function saveEdits(formid,updateid, filepath) {
//get the editable element
var editElem = document.getElementById(formid).value;
var data = new FormData();
data.append("data" , editElem);
data.append("filepath" , filepath);
var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
xhr.open( 'post', 'http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/index.php', true );
xhr.send(data);
//write a confirmation to the user
document.getElementById(updateid).innerHTML="Edits saved!";
}
    
    $(document).ready(function() {
       $("#title-menu").click(function() {
           var target = String($(this).val());
           $("#dropdown-description").html(target.toUpperCase() + '<span class="caret"></span>');
            $.get("updateMethod.php", {method:target}, function(response){
                $("#viewButton1").html(response);
                var count = response.split('>').pop().trim();
                console.log(count);
                $('#viewButton1').attr("size", count);
                });
           $(".comment_box").html(target.toUpperCase());
           $(".comment_content").html( "\<\?php echo trim(file_get_contents(\'./MULTICOM_Methods/"+target+"/comments.txt\', true));?>");
            });
    });

//    
//    $(document).ready(function() {
//       $("#title-menu").click(function() {
//           var target = String($(this).val());
//           $("#dropdown-description").html(target.toUpperCase() + '<span class="caret"></span>');
//            $.get("updateMethod.php", {method:target}, function(response){
//                console.log("This was the response " + response);
//                $("#viewButton1").html(response);
//                var count = response.split('>').pop().trim();
//                console.log(count);
//                $('#viewButton1').attr("size", count);
//                });
//           $(".comment_box").html(target.toUpperCase());
//           location.href = "http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/index.php?method=" + target;
//            });
//    });
//    
	
//    $(document).ready(function() {
//       $("#dncon2_run").click(function() {
//           var target = String($(this).val());
//		   var array_tmp = target.split('.');
//		   var targetname=array_tmp[0]
//		   //alert(target);
//		   //alert(targetname);
//		   //alert("http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw=http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/dncon2/"+target+"&job_id="+targetname);
//           document.getElementById('dncon2_iframe').src = "http://iris.rnet.missouri.edu/cgi-bin/casp13_dashboard/coneva/main_v2.0_server.cgi?rr_raw=http://iris.rnet.missouri.edu/casp13_dashboard/CASP13_dashboard/MULTICOM_Methods/dncon2/"+target+"&job_id="+targetname;
//           document.getElementById('dncon2_iframe').width = "100%";
//           document.getElementById('dncon2_iframe').height = "100%";
//            });
//    });
	
$(document).ready(function() {
    var opt = $("#dncon2_run option").sort(function (a,b) { return a.value.toUpperCase().localeCompare(b.value.toUpperCase()) });
    $("#dncon2_run").append(opt);
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
	fwrite($file, $data);
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
        <h2 id="subtitle">Critical Assesment of Techniques for Protein Structure Prediction</h2>
    </div>
        <div class="container">
        <div class="visualization-container">
        <div class="col-md-6">
            <div class="dropdown col-md-3 text-left">
                <button id="dropdown-description" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo strToUpper($method_id) ?><span class="caret"></span></button>
                <select  class="dropdown-menu" id="title-menu" multiple="multiple" aria-labelledby="dropdownMenu1" size=3>
							<?php
                    
							if ($handle = opendir('MULTICOM_Methods/')) {
								$blacklist = array('.', '..','comments.txt');
								while (false !== ($file = readdir($handle))) {
									if (!in_array($file, $blacklist)) {
										$file = rtrim($file);
										echo "<option><button id=\"#$file\" type=\"button\"  value=\"$file\">$file</button></option>\n";
									}
								}
								closedir($handle);
							}
							?>
						
                    </select >
            </div>
			<?php if($method_id == 'multicom' or $method_id == 'confold2'){ ?> 
				<div class="dropdown col-md-2 text-left">
				    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Please select the target
							<span class="caret"></span>
						</button>
					
				    <select class="dropdown-menu dropdown-menu-center" id="viewButton1" multiple="multiple" aria-labelledby="dropdownMenu1" size=13>
				        <?php
				            if ($handle = opendir("MULTICOM_Methods/$method_id")) {
									$blacklist = array('.', '..','comments.txt');
									while (false !== ($file = readdir($handle))) {
										if (!in_array($file, $blacklist) and strpos($file, '.pdb') !== false) {
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
								var append = "";
								Jmol.getApplet("jsmolAppletM1", Info);
								Jmol.script(jsmolAppletM1,"background black; load MULTICOM_Methods/multicom/T01/model1.pdb;");
								Jmol.script(jsmolAppletM1, "spin on; cartoon only; color {file="+ rfile+"} group;");
								
								Jmol.jmolCheckbox(jsmolAppletM1,"","","Predicted Structure", true, "refinedCheck");
								
								$(document).ready(function() {
									$("#viewButton1").click(function() {
										var methodName = $("#dropdown-description").text();
										var target = String($(this).val());
										target = target.replace(/\n/g, '');
										if ($("#refinedCheck").prop("checked")) {
											Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
											//Jmol.script(jsmolAppletM1,"background black; load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+"/model1.pdb;");	
											Jmol.script(jsmolAppletM1,"background black; load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+";");		
											Jmol.script(jsmolAppletM1, "spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										else {
											$("#refinedCheck").prop("checked", true);
											//Jmol.script(jsmolAppletM1,"background black; load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target +"/model1.pdb;");	
											Jmol.script(jsmolAppletM1,"background black; load MULTICOM_Methods/" + methodName.toLowerCase() + "/"+target+";");		
											Jmol.script(jsmolAppletM1, "spin on; cartoon only; color {file="+ rfile+"} group;");
										}
										append = "";
										$("#modelTitle").html("Representative Conformation in Top 1 Fold");
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
			<?php  } ?>
			
			<?php if($method_id == 'dncon2'){ ?>
				<div class="col-md-1">
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Please select the target (need 1~5 seconds to load)
							<span class="caret"></span>
						</button>
					
						<select class="dropdown-menu" id="dncon2_run" multiple="multiple" aria-labelledby="dropdownMenu1">
							<?php
								
								if ($handle = opendir("MULTICOM_Methods/$method_id")) {
									$blacklist = array('.', '..','comments.txt');
									while (false !== ($file = readdir($handle))) {
										if (!in_array($file, $blacklist) and strpos($file, '.rr') !== false) {
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
					<iframe id="dncon2_iframe" src=""  width="100%"  height="10%" ></iframe><br/>					
				</div>
			<?php  } ?>
        </div>
        </div>
            
        <div class="updateBox">
            <h1>Testing</h1>
            <h1>Testing</h1>
            <h1>Testing</h1>
            <h1>Testing</h1>
        </div>
            </div>
        <div class="row comments">
            <div class=" col-md-5">
                <h2><?php echo $method_id ?></h2>
            </div>
        </div>
        <div class="row comments col-md-5">
            <?php if ($method_id == 'multicom'){ ?>
					<textarea  id="edit_comment2" rows="4" cols="50" class="comment_content">  <?php echo trim(file_get_contents("./MULTICOM_Methods/$method_id/comments.txt", true));?> </textarea><br>
					<input type="button" value="save my comments" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/multicom/comments.txt')"/>
					<div id="update2"> - Edit the text and click to save for next time</div>
            <?php }else if($method_id == 'dncon2'){ ?>
					<textarea  id="edit_comment2" rows="4" cols="50" class="comment_content">  <?php echo trim(file_get_contents("./MULTICOM_Methods/$method_id/comments.txt", true));?> </textarea><br>
					<input type="button" value="save my comments" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/dncon2/comments.txt')"/>
					<div id="update2"> - Edit the text and click to save for next time</div>
            <?php }else if($method_id == 'confold2'){?>
					<textarea  id="edit_comment2" rows="4" cols="50" class="comment_content">  <?php echo trim(file_get_contents("./MULTICOM_Methods/$method_id/comments.txt", true));?> </textarea><br>
					<input type="button" value="save my comments" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/confold2/comments.txt')"/>
					<div id="update2"> - Edit the text and click to save for next time</div>
            <?php }else{?>
					<textarea  rows="4" cols="50">  <?php echo "No comments for this method";?> </textarea><br>
            <?php }?>
        </div> 
    </div>
</body>
</html>