<?php
// FileName: tts.php
/*
 *  A PHP Class that converts Text into Speech using Google's Text to Speech API
 *
 * Author:
 * Abu Ashraf Masnun
 * http://masnun.com
 *
 */
 
class TextToSpeech {

    public $mp3data;
    public $ogg;
    
    function __construct($text="") {

	//FOR MP3 TO OGG
    require "audioconvert_class_inc.php";
       
        $text = trim($text);
        if(!empty($text)) {
            $text = urlencode($text);
            //http://translate.google.com/translate_tts?tl=en&q=text
            $this->mp3data = file_get_contents("http://translate.google.com/translate_tts?tl=en&q={$text}");
            //echo "data: " . $this->mp3data;
        }
    }
 
 
//////////////////////////////////////
//									//
// 	ONLY USING THIS SECTION OF TTS  //
//									//
//////////////////////////////////////



    function setText($text,$file_name) {
        $text = trim($text);
        if(!empty($text)) {
            $text = urlencode($text);

			//$this->mp3data = file_get_contents("http://tts-api.com/tts.mp3?q={$text}");
			$this->mp3data = file_get_contents("http://translate.google.com/translate_tts?tl=en&q={$text}");   
			$put_file = "/var/www/html/b9000/sound_files/".$file_name.".mp3";
			//echo "put: ". $put_file;
			file_put_contents($put_file, $this->mp3data);
			chmod($put_file, 0777); 
			
			/*
			$convert = new audioconvert();
			$put_file2 = "/var/www/html/b9000/sound_files/".$file_name.".ogg"
			//$this->ogg = $convert->mp32OggFile($put_file, $put_file2,false);
			///var/www/vhosts/heckleonline.com/httpdocs/
			//$put_file = "/var/www/html/b9000/sound_files/".$file_name.".ogg";
			//file_put_contents($put_file, $this->ogg);
			shell_exec("sox $put_file $put_file2");
			chmod($put_file2, 0777); 
			*/
         	
            //echo "data: " . $this->mp3data;
			$mp3data = $this->mp3data;
			//echo "$put_file,";
            return $mp3data;
        } else { return false; }
    }
 
    function saveToFile($filename) {
        $filename = trim($filename);
        if(!empty($filename)) {
            return file_put_contents($filename,"/var/www/html/b9000/sound_files/".$this->mp3data);
        } else { return false; }
    }

}
?>