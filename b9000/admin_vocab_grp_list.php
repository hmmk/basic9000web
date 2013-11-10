<?php
	require_once 'common/com_function.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		
?>
<div id="main">
	<h2>Show all the vocab</h2>
    
<?php
			$rows = get_assessment_list();	
?>

		<table border="1">
            <thead>
                <tr>
                    <td width="5%"><b>GID</b></td>
                    <td width="10%"><b>Name</b></td>
                    <td><b>Desc</b></td>
                    <td width="5%"><b>Level</b></td>
                    <td width="5%"><b>Chance</b></td>
                    <td width="10%"><b>Updated Date</b></td>
                    <td width="10%"><b>Updated By</b></td>
                </tr>

            </thead>
            <tbody>
<?php
			foreach($rows as $g_record){
?>
                <tr>
                    <td><?=$g_record['gid'];?></td>
                    <td><a href="admin_vocab_grp_list_all.php?gid=<?=$g_record['gid'];?>"><?=$g_record['name'];?></a></td>
                    <td><?=$g_record['desc'];?></td>
                    <td><?=$g_record['lvl'];?></td>
                    <td><?=$g_record['chance'];?></td>
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
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>