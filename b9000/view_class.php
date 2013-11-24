<?php
	require_once 'config/basic_conf.php';
	require_once 'common/com_function.php';
	require_once 'common/record_fuction.php';
	
    include ('header.php');
	$cur_term = CUR_TERM;
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		
?>
<div id="main">
	<h2>View Students' Results by Class</h2>
    
<?php
		for($i = 1; $i <= 6; $i++){
			$rows = get_class_list_by_form($i,$cur_term);
?>
			<h3>S<?=$i;?></h3>
        	<p>
<?php
			foreach($rows as $g_record){
?>
				<a href="view_class_result.php?class=<?=strtolower($g_record['class']);?>"><?=$g_record['class'];?></a>&nbsp;&nbsp;&nbsp;
<?php
			}
		}
?>
		</p>
</div>
<?php
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>