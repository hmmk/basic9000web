<?php
	require_once 'common/admin_function.php';
	require_once 'common/com_function.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		$cur_gid = $_GET['gid'];
		
		// If the form hasn't been posted, display error.
		if($_SERVER['REQUEST_METHOD'] != 'GET' || !$cur_gid)
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
			"aaSorting": [[0,'asc']],
			"aoColumns": [ null, null,null,null,null,null,null],
			"iDisplayLength": 50,
			"aLengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
			"sDom": 'T<"clear">flrtip',
			"oTableTools": { "aButtons": [ "copy", "csv", "print" ] }
		} ).columnFilter();
		
			
	} );
</script>

<div id="main">
	<h2>Show all the vocab</h2>
    
<?php
			$rows = get_all_vocab_by_gid($cur_gid);	
?>

		<table border="1" class="search_records" id="search_records">
            <thead>
                <tr>
                    <td width="5%"><b>WID</b></td>
                    <td width="15%"><b>Vocab</b></td>
                    <td><b>Explanation</b></td>
                    <td><b>解釋</b></td>
                    <td><b>Sound Path</b></td>
                    <td width="10%"><b>Updated Date</b></td>
                    <td width="10%"><b>Updated By</b></td>
                </tr>

            </thead>
            <tbody>
<?php
			foreach($rows as $g_record){
?>
                <tr>
                    <td><?=$g_record['wid'];?></td>
                    <td><?=$g_record['vocab'];?></a></td>
                    <td><?=$g_record['explanation_en'];?></td>
                    <td><?=$g_record['explanation_cn'];?></td>
                    <td><?=$g_record['sound_path'];?></td>
                    <td><?=$g_record['last_updated'];?></td>
                    <td><?=$g_record['last_updated_by'];?></td>
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