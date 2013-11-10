<?php
    require_once 'config/DatabasePDO.php';
	require_once 'config/basic_conf.php';
	require_once 'common/com_function.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'A')){
		
		$cur_id = $_SESSION['uid'];
		
		$cur_stu_info = get_student_info($cur_id);

?>
<div id="main">
  <h2>Welcome Back, <?=$cur_stu_info['name_eng']?> <?=$cur_stu_info['class']?> <?=$cur_stu_info['class_no']?></h2>
  
  <!--<p>Records: Check the past record</p>-->
  <p>Assessment: Quiz for the vocabulary</p>
  <p>Account Mgmt: Change your login password</p>

</div>
<?php
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>