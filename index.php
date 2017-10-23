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
    
<link rel="stylesheet" href="style.css">
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
           $("#dropdown-description").html(target + '<span class="caret"></span>');
            $.get("updateMethod.php", {method:target}, function(response){
                console.log("This was the response " + response);
                $("#viewButton1").html(response);
                });
            });
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
        <div class="container">
        <div class="row">
            <form id="methodSelection">
            <div class="dropdown">
                <button id="dropdown-description" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">MULTICOM<span class="caret"></span></button>
                <select  class="dropdown-menu" id="title-menu" multiple="multiple" aria-labelledby="dropdownMenu1">
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
        </form>
        </div>
        <div class="row">
            <div class="col-xs-1">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        #1
                        <span class="caret"></span>
                    </button>
                
                    <select class="dropdown-menu" id="viewButton1" multiple="multiple" aria-labelledby="dropdownMenu1">
                    </select >
                </div>
            </div>
            <div class="col-xs-3 method_box">
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
                                    console.log("This is the method name " + methodName);
									var target = String($(this).val());
									target = target.replace(/\n/g, '');
									if ($("#refinedCheck").prop("checked")) {
										Jmol.script(jsmolAppletM1, "zap file=" + rfile + ";");
										Jmol.script(jsmolAppletM1,"background black; load MULTICOM_Methods/" + methodName + "/"+target+"/model1.pdb;");	
										Jmol.script(jsmolAppletM1, "spin on; cartoon only; color {file="+ rfile+"} group;");
									}
									else {
										$("#refinedCheck").prop("checked", true);
										Jmol.script(jsmolAppletM1,"background black; load MULTICOM_Methods/" + methodName + "/"+target+"/model1.pdb;");	
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
            </div>
        <div class="row">
            <div  class="col-xs-4">
                <h2 class="comment_box">MULTICOM Comment</h2>
				<textarea  id="edit_comment2" rows="4" cols="50">  <?php echo trim(file_get_contents('./MULTICOM_Methods/multicom/comments.txt', true));?> </textarea><br>
				<input type="button" value="save my comments" onclick="saveEdits('edit_comment2','update2','./MULTICOM_Methods/multicom/comments.txt')"/>
				<div id="update2"> - Edit the text and click to save for next time</div>
            </div> 
        </div>
    </div>
</body>
</html>