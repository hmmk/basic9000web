<?php
	require_once 'common/com_function.php';
	require_once 'common/admin_function.php';
	require_once 'common/tts.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'S')){
		
		if ( isset($_GET['gid']) && $_GET['gid']) {
			$gid = $_GET['gid'];
?>
<div id="main">
	  
<?php

			$vocabs = get_vocab_list_by_gid($gid);
			
			$tts = new TextToSpeech();
?>			
			<h2>Start converting MP3</h2>
            <pre>
<?php			
			foreach($vocabs as $v_record){
				$file_name = str_replace( ' ', '', $v_record['vocab'] );
				
				/*
				* Google Blocked the app1.cymcass.edu.hk IP
				* so no MP3 can download
				*/
				$tts->setText($v_record['vocab'],$file_name);
				update_vocab_mp3_path($v_record['wid'],'sound_files/'.$file_name.'.mp3',$_SESSION['uid']);
			}
?>			
			</pre>
			<h2>Finish</h2>
			

</div>
<?php
		} else {
			echo "<h2>You dont have permission!</h2>";
		}
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>