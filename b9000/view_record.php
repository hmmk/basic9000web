<?php
	require_once 'config/basic_conf.php';
	require_once 'common/record_fuction.php';
	require_once 'common/com_function.php';
	
	include ('header.php');
	$cur_term = CUR_TERM;
	$d_lkup_values_ary = get_class_list_ary ();
		
?>
<script type="text/javascript" charset="utf-8">
	
	$(document).ready(function() {
		$('#search_records').dataTable( {
			"aaSorting": [[2,'asc'], [3,'asc'], [4,'asc']],
			"aoColumns": [ { "bSortable": false }, null,null,null,null,null,null],
			"iDisplayLength": 50,
			"aLengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
			"sDom": 'T<"clear">flrtip',
			"oTableTools": { "aButtons": [ "copy", "csv", "print" ] }
		} ).columnFilter( {
			aoColumns: [ null, null, { type: "select" , values: [ '1', '2', '3', '4', '5', '6'] }, { type: "select", values:<?php echo json_encode($d_lkup_values_ary); ?>}, { type: "text" },{ type: "text" },null ]
		} );
		
			
	} );
</script>
<?php
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		$cur_act = $_GET['act'];

		// If the form hasn't been posted, display error.
		if($_SERVER['REQUEST_METHOD'] != 'GET' || !$cur_act)
		{
			echo '<p>Sorry, you cannot access this page.</p>';
		}
		// Otherwise, start to save the posed data
		else
		{
			if ($cur_act == 'all'){
				$s_records = get_all_students_list ($cur_term);
			} else if ($cur_act == 'staff'){
				$s_records = get_all_staff_list ();
			}

		
?>      
		<h2>All Student Records</h2>
		
		<table class="search_records" id="search_records">
            <thead>
                <tr>
	                <td><b>Result</b></td>
	                <td width="10%"><b>Term</b></td>
                    <td width="5%"><b>Form</b></td>
                    <td width="10%"><b>Class</b></td>
                    <td width="10%"><b>Class No</b></td>
                    <td><b>Name</b></td>
                    <td><b>UID</b></td>
                </tr>
                <tr>
                	<th></th>
                    <th></th>
                    <th></th>
                	<th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php
			foreach($s_records as $s_record){
?>
                <tr>
	                <td><a href="view_result.php?uid=<?=$s_record['uid'];?>">View</a></td>
                    <td><?=$s_record['term'];?></td>
                    <td><?=$s_record['form'];?></td>
                    <td><?=$s_record['class'];?></td>
                    <td><?=$s_record['class_no'];?></td>
                    <td><?=$s_record['name_eng'];?></td>
                    <td><?=$s_record['uid'];?></td>
                </tr>
<?php
			}
?>
            </tbody>
		</table>

<?php
		}
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
include 'footer.php';
?>