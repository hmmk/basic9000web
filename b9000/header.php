<?php
if(!isset($_SESSION)) { 
	session_start(); 
} 
	require_once 'config/DatabasePDO.php';
	require_once 'config/basic_conf.php';

	$_SESSION['sys'] = 'b9000';
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/main.css"/>
    <style type="text/css" title="currentStyle">
		@import "css/jquery.dataTables.css";
		@import "css/jquery.dataTables_themeroller.css";
		@import "css/TableTools.css";
	</style>
	<title>CYMCASS Basic 9000 Web (B9000W)</title>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/ZeroClipboard.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/TableTools.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/jquery.dataTables.columnFilter.js"></script>

</head>
<body>
	<p><img src="img/sch_logo.jpg">Basic 9000 Web (B9000W)</p>
    <div id="top" width="2000">
        
	<table class="menu">
            <tr>
                <td><a href="index.php">Home</a></td>
                
                <!--<td><a href="records.php">Records</a></td>-->
                
                <td><a href="assessment.php">Assessment</a></td>
                
                <?php
                    if (isset($_SESSION['login_success']) && $_SESSION['login_success']){
						
						if ($_SESSION['urole']=='T' || $_SESSION['urole']=='N'){
							echo "<td><a href=\"admin.php\">Teacher/Admin page</a></td>";
						}
						
						echo "<td><a href=\"../mlogin/\">Account Mgmt.</a></td>";
                        echo "<td><a href=\"../mlogin/logout.php\">Logout [".$_SESSION['uid']."]</a></td>";
                    } else {
                        echo "<td><a href=\"../mlogin/login.php\">Login</a></td>";
                    }
                ?>
				
            </tr>
        </table>
    </div>
