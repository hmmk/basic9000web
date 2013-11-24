<?php
	require_once 'config/basic_conf.php';
	require_once 'common/com_function.php';
	require_once 'common/vocab_fuction.php';
	
    include ('header.php');
	$cur_term = CUR_TERM;
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'A')){

?>
<div id="main">
	<h2>Let's start the assessment!</h2>
    
<?php
			$rows = get_assessment_list();	
?>

		<table border="1">
            <thead>
                <tr>
                    <td width="20%"><b>Assessment</b></td>
                    <td><b>Description</b></td>
                    <td width="15%"><b>Level</b></td>
                    <td width="10%"><b>Chance</b></td>
                    <td width="10%"><b>No. of Vocab.</b></td>
                    <td width="15%"><b>Completion</b></td>
                    <td width="10%"><b>Term <?=$cur_term?> Marks</b></td>
                    
                </tr>

            </thead>
            <tbody>
<?php
			foreach($rows as $g_record){
				$grp_vocab_cnt = get_grp_vocab_cnt($g_record['gid']);
				$grp_stu_mark = get_stu_term_mark_by_grp($g_record['gid'],$_SESSION['uid'],$cur_term);
				$complete_word_cnt = get_complete_word_cnt($g_record['gid'],$_SESSION['uid']);
?>
                <tr>
                    <td><a href="assess_do.php?a=st&w=0&g=<?=$g_record['gid'];?>"><?=$g_record['name'];?></a></td>
                    <td><?=$g_record['desc'];?></td>
                    <td><?=$g_record['lvl'];?></td>
                    <td><?=$g_record['chance'];?></td>
                    <td><?=$grp_vocab_cnt?></td>
                    <td><?=$complete_word_cnt?> (<?=percentage($complete_word_cnt, $grp_vocab_cnt, 0)."%";?>)</td>
                    <td><?=$grp_stu_mark?></td>
                </tr>
<?php
			}
?>
            </tbody>
		</table>
</div>
<?php
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>