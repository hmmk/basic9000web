
<?php
require_once 'config/DatabasePDO.php';
require_once 'config/basic_conf.php';

function get_vocab_by_wid($wid) {
	
	$database = new DatabasePDO();
	$database->query('SELECT a.wid, a.vocab, a.gid, a.explanation_cn, a.explanation_en, a.sound_path FROM cymcass.b9_eng_vocab AS a WHERE a.wid = :wid;');
	$database->bind(':wid', $wid);
	$row = $database->single();
		
	return $row;
}

function insert_success_vocab($wid, $gid, $uid){
	$cur_term = CUR_TERM;
	
	$database = new DatabasePDO();
	
	$database->query('SELECT count(1) AS cnt FROM cymcass.b9_stu_vocab_rec_log WHERE uid = :uid AND GID = :gid AND WID = :wid AND ind_success = :ind_success;');
	$database->bind(':uid', $uid);
	$database->bind(':gid', $gid);
	$database->bind(':wid', $wid);
	$database->bind(':ind_success', 'Y');
	$row = $database->single();
	
	if ($row['cnt'] == 0) {
				
		$database->query('INSERT INTO cymcass.b9_stu_vocab_rec_log (uid,term,gid,wid,ind_success,last_updated_by) VALUES (:uid,:term,:gid,:wid,:ind_success,:last_updated_by);');
		$database->bind(':uid', $uid);
		$database->bind(':term', $cur_term);
		$database->bind(':gid', $gid);
		$database->bind(':wid', $wid);
		$database->bind(':ind_success', 'Y');
		$database->bind(':last_updated_by', $uid);
		$database->execute();
		
		$return_id = $database->lastInsertId();
	
	} else {
		$return_id = 0;
	}

	return $return_id;
}

/*
*
* upadte rules: all word ("word that student finished or not finished" are "the word nees to do"
*
*/
function get_next_word_id($wid,$gid,$uid) {
	$database = new DatabasePDO();
	
	$database->query("SELECT a.wid FROM cymcass.b9_eng_vocab AS a WHERE gid = :gid AND a.wid > :wid LIMIT 1");
	$database->bind(':wid', $wid);
	$database->bind(':gid', $gid);
	
/*
* OLD get next word rules:
* "b9_eng_vocab" (all word) minus "b9_stu_vocab_rec_log" (studnet finished word) = word need to do
*	
	$database->query("SELECT a.wid FROM cymcass.b9_eng_vocab AS a WHERE gid = :gid AND a.wid > :wid AND a.wid NOT IN ( SELECT b.wid FROM b9_stu_vocab_rec_log AS b WHERE b.uid = :uid AND b.gid = :gid AND b.ind_success = :ind_success ) LIMIT 1");
	$database->bind(':wid', $wid);
	$database->bind(':ind_success', 'Y');
	$database->bind(':gid', $gid);
	$database->bind(':uid', $uid);
*/
	$row = $database->single();	
	return $row;
}



function get_complete_word_cnt($gid,$uid) {
	$database = new DatabasePDO();
	
	$database->query("SELECT count(1) as cnt FROM b9_stu_vocab_rec_log WHERE uid = :uid AND gid = :gid AND ind_success = :ind_success");
	$database->bind(':ind_success', 'Y');
	$database->bind(':gid', $gid);
	$database->bind(':uid', $uid);
	$row = $database->single();	
	return $row['cnt'];
}

function get_grp_chance($gid) {
	$database = new DatabasePDO();
	
	$database->query("SELECT a.chance FROM cymcass.b9_master_eng_vocab_grp AS a WHERE a.gid = :gid;");
	$database->bind(':gid', $gid);
	$row = $database->single();	
	return $row['chance'];
}

function add_mark_success_vocab($gid, $uid){
	$cur_term = CUR_TERM;
	
	$database = new DatabasePDO();

	$database->query('INSERT INTO cymcass.b9_stu_ranking (uid, term, gid, mark) VALUES (:uid, :term, :gid, :mark ) ON DUPLICATE KEY UPDATE mark = mark + 1;');
	$database->bind(':uid', $uid);
	$database->bind(':term', $cur_term);
	$database->bind(':gid', $gid);
	$database->bind(':mark', 1);
	$database->execute();
	$return_cnt = $database->rowCount();

	return $return_cnt;
}

function get_stu_term_mark_by_grp($gid,$uid,$term) {
	$database = new DatabasePDO();
	
	$database->query("SELECT IFNULL(MIN(mark),0) as smark FROM cymcass.b9_stu_ranking WHERE uid = :uid AND gid = :gid AND term = :term");
	$database->bind(':term', $term);
	$database->bind(':gid', $gid);
	$database->bind(':uid', $uid);
	$row = $database->single();	
	return $row['smark'];
}

?>