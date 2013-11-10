// JavaScript Document
$(document).ready(function() {
	$('#waiting').show(500);
	
	$.ajax({
		type : 'POST',
		url : 'assess_ajax_do.php',
		dataType : 'json',
		data: {
			gid : 11
		},
		success : function(data){
			$('#waiting').hide(500);
			$('#message').removeClass().addClass((data.error === true) ? 'error' : 'success')
				.text(data.msg).show(500);
			if (data.error === true)
				$('#demoForm').show(500);
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			$('#waiting').hide(500);
			$('#message').removeClass().addClass('error')
				.text('There was an error.').show(500);
			$('#demoForm').show(500);
		}
	});
	
	var answer =  "";
	//<?php echo $cur_word; ?>
	var ans_len = answer.length;
	//alert('CNT:' + ans_len);
	for (var i=0;i<ans_len;i++) { 
		//alert('iCNT:' + i);
		var fulltext = $('#toptips').text() + "? ";
		$('#toptips').text(fulltext);
	}
});

$(document).keydown(function(e) {
							 
	var nodeName = e.target.nodeName.toLowerCase();
	//alert(e.which);
	
	if (e.which === 8 || e.which == 116) {
		if (((nodeName === 'input' && (e.target.type === 'text' || e.target.type === 'email')) || nodeName === 'textarea') && e.target.readOnly == false) {
			// do nothing
		} else {
			e.preventDefault();
		}
	} else if ((65 <= e.which && e.which <= 65 + 25) || (97 <= e.which && e.which <= 97 + 25) ){
		var inputText = String.fromCharCode(e.which);
		var answer =  "";
		//<?php echo $cur_word; ?>
		answer = answer.toLowerCase();
		var ans_len = answer.length;
		var cnt = parseInt($('#wi_cnt').text());
		//alert('CNT:' + cnt);
		//alert('CNT:' + answer.charAt(cnt) + ";" + inputText.toLowerCase());
		if (answer.charAt(cnt) == inputText.toLowerCase()){
			var new_cnt = cnt + 1;
			$('#wi_cnt').text(new_cnt);
			var fulltext = $('#toptitle').text() + inputText;
			$('#toptitle').text(fulltext);
		} else {
			var try_cnt = parseInt($('#try_cnt').text()) + 1;
			$('#try_cnt').text(try_cnt);
		}
		var chance = <?php echo $cur_chance; ?>;
		if (parseInt($('#try_cnt').text()) >= chance) {
			alert ('Wrong! The answer is : ' + answer.toUpperCase());
		}
		//alert (inputText);
	} //else {
		//alert(e.which);
	//}
});
