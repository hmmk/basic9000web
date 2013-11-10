<?php
	require_once 'common/com_function.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'A')){
		
		$cur_gid = $_GET['g'];
		$cur_uid = $_SESSION['uid'];
		
		// If the form hasn't been posted, display error.
		if($_SERVER['REQUEST_METHOD'] != 'GET' || !$cur_gid )	{
			echo '<p>Sorry, you cannot access this page.</p>';
		} else {
			$grp_desc = get_grp_desc($cur_gid);
?>
			<h2>Assessment <?=$grp_desc['name']?> Finish! </h2>
            <p>You can try <a href="assessment.php">another assessment</a>.</p>
			
<?php
		}
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>