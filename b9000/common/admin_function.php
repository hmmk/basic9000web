<?php
require_once 'config/DatabasePDO.php';
require_once 'config/basic_conf.php';


function update_vocab_mp3_path($wid,$path,$update_by) {
	
	$database = new DatabasePDO();
	$database->query("UPDATE cymcass.b9_eng_vocab SET sound_path=:path, last_updated_by=:last_updated_by WHERE wid=:wid ;");
	$database->bind(':last_updated_by', $update_by);
	$database->bind(':wid', $wid);
	$database->bind(':path', $path);
	$database->execute();
		
	return true;
}

function get_all_vocab_by_gid ($gid){

	$database = new DatabasePDO();
	$database->query('SELECT a.wid, a.gid, a.vocab, a.explanation_en, a.explanation_cn, a.sound_path, a.last_updated, a.last_updated_by FROM cymcass.b9_eng_vocab AS a WHERE a.gid = :gid;');
	$database->bind(':gid', $gid);
	$values = $database->resultset();	

	return $values;
}


?>