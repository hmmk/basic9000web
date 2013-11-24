<?php
	require_once 'config/basic_conf.php';
	require_once 'common/com_function.php';
	require_once 'common/vocab_fuction.php';
	require_once 'common/record_fuction.php';
	
	include ('header.php');
	$cur_term = CUR_TERM;
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		
		$cur_class = $_GET['class'];
		// If the form hasn't been posted, display error.
		if($_SERVER['REQUEST_METHOD'] != 'GET' || !$cur_class)
		{
			echo '<p>Sorry, you cannot access this page.</p>';
		}
		// Otherwise, start to save the posed data
		else
		{
?>
<script type="text/javascript" charset="utf-8">
	
	$(document).ready(function() {
		$('#search_records').dataTable( {
			"aaSorting": [ [2,'asc'],[4,'asc']],
			"aoColumns": [ null,null,null,null,null, null,null,null,null,null,null],
			"iDisplayLength": 100,
			"aLengthMenu": [[100, 200, 500, -1], [100, 200, 500,"All"]],
			"sDom": 'T<"clear">flrtip',
			"oTableTools": { "aButtons": [ "copy", "csv", "print" ] }
		} );
		
			
	} );
</script>
<div id="main">
	<h3>Class: <?=strtoupper($cur_class)?></h3>
    <h3>Assessment Result</h3>
    
<?php
			$g_rows = get_assessment_list();
			
			$s_rows = get_students_list_by_class ($cur_term, $cur_class);
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
                </tr>-->
            </thead>
            <tbody>
<?php
			foreach($s_rows as $s_record){
				foreach($g_rows as $g_record){
					$grp_vocab_cnt = get_grp_vocab_cnt($g_record['gid']);
					$complete_word_cnt = get_complete_word_cnt($g_record['gid'],$s_record['uid']);
?>
                <tr>
                	<td><?=$s_record['uid'];?></td>
                	<td><?=$s_record['class'];?></td>
                	<td><?=$s_record['class_no'];?></td>
                	<td><?=$s_record['name_eng'];?></td>
	                <td><?=$g_record['gid'];?></td>
                    <td><?=$g_record['name'];?></td>
                    <td><?=$g_record['lvl'];?></td>
                    <td><?=$g_record['chance'];?></td>
                    <td><?=$grp_vocab_cnt?></td>
                    <td><?=$complete_word_cnt?></td>
                    <td><?=percentage($complete_word_cnt, $grp_vocab_cnt, 0)."%";?></td>
                </tr>
<?php
				}
				
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