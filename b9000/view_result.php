<?php
	require_once 'common/com_function.php';
	require_once 'common/vocab_fuction.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		
		$cur_uid = $_GET['uid'];
		// If the form hasn't been posted, display error.
		if($_SERVER['REQUEST_METHOD'] != 'GET' || !$cur_uid)
		{
			echo '<p>Sorry, you cannot access this page.</p>';
		}
		// Otherwise, start to save the posed data
		else
		{
			$student_info = get_student_info($cur_uid);

?>
<script type="text/javascript" charset="utf-8">
	
	$(document).ready(function() {
		$('#search_records').dataTable( {
			"aaSorting": [ [4,'asc']],
			"aoColumns": [ null,null,null,null,null, null,null,null,null,null,null,null],
			"iDisplayLength": 50,
			"aLengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
			"sDom": 'T<"clear">flrtip',
			"oTableTools": { "aButtons": [ "copy", "csv", "print" ] }
		} );
		
			
	} );
</script>
<div id="main">
	<h3><?=$student_info['class']?> (<?=$student_info['class_no']?>) <?=$student_info['name_eng']?></h3>
    <h3>Assessment Result [<?=$cur_uid?>]</h3>
    
<?php
			$rows = get_assessment_list();	
?>

		<table class="search_records" id="search_records">
            <thead>
                <tr>
                    <td><b>UID</b></td>
                    <td><b>Class</b></td>
                    <td><b>Class No</b></td>
                    <td><b>Name</b></td>
                    <td><b>AID</b></td>
                    <td><b>Assessment</b></td>
                    <td><b>Description</b></td>
                    <td width="5%"><b>Level</b></td>
                    <td width="5%"><b>Chance</b></td>
                    <td width="5%"><b>No. of Vocab.</b></td>
                    <td width="5%"><b>Completion</b></td>
                    <td width="5%"><b>Completion %</b></td>
                    
                </tr>
                <!--<tr>
                	<th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                	<th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>-->
            </thead>
            <tbody>
<?php
			foreach($rows as $g_record){
				$grp_vocab_cnt = get_grp_vocab_cnt($g_record['gid']);
				$complete_word_cnt = get_complete_word_cnt($g_record['gid'],$cur_uid);
?>
                <tr>
                	<td><?=$cur_uid;?></td>
                	<td><?=$student_info['class'];?></td>
                	<td><?=$student_info['class_no'];?></td>
                	<td><?=$student_info['name_eng'];?></td>
	                <td><?=$g_record['gid'];?></td>
                    <td><?=$g_record['name'];?></td>
                    <td><?=$g_record['desc'];?></td>
                    <td><?=$g_record['lvl'];?></td>
                    <td><?=$g_record['chance'];?></td>
                    <td><?=$grp_vocab_cnt?></td>
                    <td><?=$complete_word_cnt?></td>
                    <td><?=percentage($complete_word_cnt, $grp_vocab_cnt, 0)."%";?></td>
                </tr>
<?php
			}
?>
            </tbody>
		</table>
</div>
<?php
		}
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>