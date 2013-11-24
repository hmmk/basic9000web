<?php
require_once 'config/DatabasePDO.php';
require_once 'config/basic_conf.php';

/* 
 * $login_status
 * $user_role : 
 * $criteria : A - All student, teacher and non-teaching staff, S - All teacher and non-teaching staff, T - Teachers only
*/

function check_lvl_permission ($login_status, $user_role, $criteria) {
	$return_value = false; 
	
	if ($login_status) {
		if (strcmp($criteria,'A')==0) {
			if (strcmp($user_role,'S')==0 || strcmp($user_role,'T')==0 || strcmp($user_role,'N')==0) {
				$return_value = true;
			}
		} else if (strcmp($criteria,'S')==0) {
			if (strcmp($user_role,'T')==0 || strcmp($user_role,'N')==0) {
				$return_value = true;
			}
		} else if (strcmp($criteria,'T')==0) {
			if (strcmp($user_role,'T')==0 ) {
				$return_value = true;
			}
		}
	}
	
	return  $return_value;
}

/*
* get Student Information / Teacher no photo_path, class, class_no
*
* return $row ['name_eng', 'photo_path', 'uid', 'class', 'class_no']
*/
function get_student_info($uid) {
	
	$database = new DatabasePDO();
	$database->query('SELECT a.name_eng, a.photo_path, a.uid, b.class, b.class_no  FROM cymcass.master_user_info AS a, cymcass.master_user_group AS b WHERE a.uid = b.uid AND a.uid = :uid AND b.term = :cur_term AND b.type = :classtype;');
	$database->bind(':uid', $uid);
	$database->bind(':classtype', 'C');
	$database->bind(':cur_term', CUR_TERM);
	$row = $database->single();
		
	return $row;
}


/*
*
*/
function get_grp_vocab_cnt($gid) {
	
	$database = new DatabasePDO();
	$database->query('SELECT count(1) AS cnt FROM cymcass.b9_eng_vocab AS a WHERE gid = :gid;');
	$database->bind(':gid', $gid);
	$row = $database->single();
		
	return $row['cnt'];
}

/*
*return $row ['name', 'desc', 'lvl']
*/
function get_grp_desc($gid) {
	
	$database = new DatabasePDO();
	$database->query('SELECT a.name, a.desc, a.lvl FROM cymcass.b9_master_eng_vocab_grp AS a WHERE gid = :gid;');
	$database->bind(':gid', $gid);
	$row = $database->single();
		
	return $row;
}

function get_assessment_list() {
	
	$database = new DatabasePDO();
	$database->query('SELECT a.gid, a.name, a.desc, a.chance, a.lvl, a.last_updated, a.last_updated_by FROM cymcass.b9_master_eng_vocab_grp AS a;');
	$rows = $database->resultset();
		
	return $rows;
}

function get_vocab_list_by_gid($gid) {
	
	$database = new DatabasePDO();
	$database->query('SELECT a.gid, a.vocab, a.wid FROM cymcass.b9_eng_vocab AS a WHERE gid = :gid;');
	$database->bind(':gid', $gid);
	$vocabs = $database->resultset();
		
	return $vocabs;
}

function percentage($val1, $val2, $precision) 
{
	if ($val2 <> 0 ) {
		$division = $val1 / $val2;
		$res = $division * 100;
		$res = round($res, $precision);
	} else {
		$res = 0;
	}
	return $res;
}
?>