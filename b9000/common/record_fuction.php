<?php
require_once 'config/DatabasePDO.php';
require_once 'config/basic_conf.php';

function get_all_students_list ($term){

	$database = new DatabasePDO();
	$database->query('SELECT a.uid, b.class, b.class_no, a.name_chi, a.name_eng, a.gender, a.photo_path, b.term, c.form FROM cymcass.master_user_info AS a, cymcass.master_user_group AS b, cymcass.master_class AS c WHERE a.uid = b.uid AND c.class = b.class AND b.term = :term AND b.type = "C" ORDER BY b.class_no ASC');
	$database->bind(':term', $term);
	$values = $database->resultset();	

	return $values;
}

function get_class_list ($term){
	$database = new DatabasePDO();
	$database->query('SELECT class FROM cymcass.master_class WHERE term = :term;');
	$database->bind(':term', $term);
	$rows = $database->resultset();		
	return $rows;
}

function get_class_list_ary (){
	
	$d_lkup_values = get_class_list (CUR_TERM);
	foreach($d_lkup_values as $row_value){
		$d_lkup_values_ary[] = $row_value['class'];
	}
	return $d_lkup_values_ary;
}

function get_all_staff_list (){

	$database = new DatabasePDO();
	$database->query('SELECT a.uid, a.name_chi as class_no, a.name_eng, a.gender as class, a.photo_path as form, a.role as term FROM cymcass.master_user_info AS a WHERE a.role = "T"  OR a.role = "N" ORDER BY a.name_eng');
	$values = $database->resultset();	

	return $values;
}

?>