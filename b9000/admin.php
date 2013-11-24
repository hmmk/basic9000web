<?php
	require_once 'common/com_function.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		
		$cur_id = $_SESSION['uid'];
		
		$cur_stu_info = get_student_info($cur_id);

?>
<div id="main">

	<h2>Teacher Menu</h2>
    <p><a href="view_record.php?act=all">View All Students' Results</a></p>
    <p><a href="view_class.php">View Students' Results by Class</a></p>
    <p><a href="view_record.php?act=staff">View Teachers and Staff Results</a> [For internal test uses]</p>
    <p><a href="admin_vocab_grp_list.php">Show all the vocab</a></p>

	<h2>System Admin Menu</h2>
    <p>Update the sound files [Blocked by Google]</p>
	<!--<p><a href="admin_vocab_mp3_list.php">Update the sound files</a> [Blocked by Google, Dont Click!!! SYSTEM ERROR!]</p>-->
</div>
<?php
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>