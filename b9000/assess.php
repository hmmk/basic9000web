<?php
	require_once 'config/basic_conf.php';
	require_once 'common/com_function.php';
	require_once 'common/vocab_fuction.php';
	
    include ('header.php');
	
	if (isset($_SESSION['login_success']) && isset($_SESSION['urole']) && check_lvl_permission($_SESSION['login_success'], $_SESSION['urole'],'A')){
		$cur_gid = $_GET['g'];
		$cur_wid = $_GET['w'];
		$cur_uid = $_SESSION['uid'];

		// If the form hasn't been posted, display error.
		if($_SERVER['REQUEST_METHOD'] != 'GET' || !$cur_gid || !$cur_wid )	{
			echo '<p>Sorry, you cannot access this page.</p>';
		} else {
			
			$return_vocab = get_vocab_by_wid($cur_wid);
			$complete_word_cnt = get_complete_word_cnt($cur_gid,$cur_uid);
			$cur_word = $return_vocab['vocab'];
			$cur_chance = get_grp_chance($cur_gid);
			$no_of_vocab = get_grp_vocab_cnt($cur_gid);
			$cur_grp_desc = get_grp_desc($cur_gid);
?>
<script type="text/javascript">
// JavaScript Document
$(document).ready(function() {
	//$('#waiting').show(500);
	
	$( "#toptips" ).focus();
	
	var answer =  "<?php echo $cur_word; ?>";
	var ans_len = answer.length;
	//alert('CNT:' + ans_len);
	for (var i=0;i<ans_len;i++) { 
		//alert('iCNT:' + i);
		if (answer.charAt(i) == " " || answer.charAt(i) == "_") {
			var fulltext = $('#toptips').text() + "_ ";
		} else {
			var fulltext = $('#toptips').text() + "? ";
		}
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
		var answer =  "<?php echo $cur_word; ?>";
		//
		answer = answer.toLowerCase();
		answer = answer.replace(/\s+/g, '');
		answer = answer.replace(/_+/g, '');
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
		if ((parseInt($('#wi_cnt').text()) == ans_len) && (answer.toLowerCase() == $('#toptitle').text().toLowerCase())) {
			doNextUrl("<?php echo $cur_gid; ?>", "<?php echo $cur_wid; ?>", "<?php echo SPELL_SUCCESS; ?>");
		}
		var chance = <?php echo $cur_chance; ?>;
		if (parseInt($('#try_cnt').text()) >= chance) {
			alert ('Wrong! The answer is : ' + answer.toUpperCase());
			doNextUrl("<?php echo $cur_gid; ?>", "<?php echo $cur_wid; ?>", "<?php echo SKIP_SPELL_WRONG; ?>");
		}
		//alert (inputText);
	} //else {
		//alert(e.which);
	//}
});

function doNextUrl(gid, wid, act) {
	window.location.href = 'assess_do.php?g=' + gid + '&w=' + wid + '&a=' + act;
}
</script>
<?php  ?>

            <div id="waiting" style="display: none;">
                Please wait<br />
                <img src="img/ajax-loader.gif" title="Loader" alt="Loader" />
            </div>
    
            <h2>Assessment : <?php echo $cur_grp_desc['name']; ?></h2>
            <h2 id="toptips"></h2>
            <p id="toptitle"></p>
            <p>&nbsp;</p>
            <center>
            <audio controls="controls" autoplay="autoplay">
                <!--<source src="http://translate.google.com/translate_tts?tl=en&q=apple" type="audio/mp3" />-->
                <source src="http://tts-api.com/tts.mp3?q=<?=$cur_word;?>" type="audio/mp3" />
            </audio>
                        
            <h4><?=$return_vocab['explanation_en'];?></h4>
            <h4><?=$return_vocab['explanation_cn'];?></h4>
            </center>
            <table id="as_menu" border="1">
            <tr>
                <td>Correct Word:<?php echo $complete_word_cnt; ?>/<?php echo $no_of_vocab; ?></td>
                <td>Tried: <span id="try_cnt">0</span>/<?php echo $cur_chance; ?></td>
                <td>Correct char(s):<span id="wi_cnt">0</span></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><a href="assess_do.php?g=<?php echo $cur_gid; ?>&a=<?php echo SKIP_SPELL_WRONG; ?>&w=<?php echo $cur_wid; ?>">SKIP</a></td>
            </tr>
            </table>

<?php
		}
	} else {
		echo "<h2>Please log in first! OR You dont have permission!</h2>";
	}
	
    include ('footer.php');
?>