<?php
if(!isset($_SESSION)) { 
	session_start(); 
} 

require_once 'common/vocab_fuction.php';
require_once 'config/basic_conf.php';
require_once 'common/com_function.php';


if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'A')){

	$cur_gid = $_GET['g'];
	$cur_wid = $_GET['w'];
	$cur_act = $_GET['a'];
	$cur_uid = $_SESSION['uid'];

	// If the form hasn't been posted, display error.
	if($_SERVER['REQUEST_METHOD'] != 'GET' || !$cur_gid || $cur_wid < 0 || !$cur_act)	{
		include ('header.php');
		echo '<p>Sorry, you cannot access this page.</p>';
		include ('footer.php');
	} else {
		//Start Assessment OR Wrong/Skip the word
		if (strcmp($cur_act, SKIP_SPELL_WRONG)==0 || strcmp($cur_act, START_ASSESS)==0) {
			
			$next_wid = get_next_word_id($cur_wid,$cur_gid,$cur_uid);

		if ($next_wid['wid'] > 0) {
				header('Refresh: 0; url=assess.php?g='.$cur_gid.'&w='.$next_wid['wid']);
			} else {
				header('Refresh: 0; url=assess_end.php?g='.$cur_gid);
			}
		}
		//Success
		else if (strcmp($cur_act,SPELL_SUCCESS)==0) {
			$ind = insert_success_vocab($cur_wid, $cur_gid, $cur_uid);
			$next_wid = get_next_word_id($cur_wid,$cur_gid,$cur_uid);
			
			if ($next_wid['wid'] > 0) {
				header('Refresh: 0; url=assess.php?g='.$cur_gid.'&w='.$next_wid['wid']);
			} else {
				header('Refresh: 0; url=assess_end.php?g='.$cur_gid);
			}
		} else {
			include ('header.php');
			echo "<h3>Sorry, you cannot access this page.</h3>";
			include ('footer.php');
		}
				
	}
} else {
	echo "<h2>Please log in first! OR You dont have permission!</h2>";
}
?>