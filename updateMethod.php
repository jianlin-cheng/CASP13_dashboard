<?php
$method = $_GET['method'];
$path = 'MULTICOM_Methods/' . $method . '/';

if ($handle = opendir($path)) {
    $blacklist = array('.', '..','comments.txt');
    while (false !== ($file = readdir($handle))) {
        if (!in_array($file, $blacklist)) {
            
            $file = rtrim($file);
            $subStr = substr($file, 0, 10);
            echo $subStr;
            echo "<option><button id=\"#$file\" type=\"button\"  value=\"$file\">$file</button></option>\n";
        }
    }
    closedir($handle);
}
?>