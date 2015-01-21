<?php
//	設定無cache
header("Content-type: text/html; charset=UTF-8");
header("Expires: Sat, 1 Jan 2005 00:00:00 GMT");
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$type = safe_word($_POST['post_type']);
$result = array();

try{

	// ptt網址
	if($type == 'ptt'){
		$ptt_url = safe_uri($_POST['ptt_url']);
		// 網址沒傳 或不是ptt
		if(!$ptt_url || strrpos($ptt_url, 'www.ptt.cc/bbs/') === false){
			$result['type'] = 'input_error';
			$result['tag_id'] = 'ptt_url';
			throw new Exception();	
		}

		$return = get_ptt($ptt_url);

		$result['type'] = 'ptt_table';
		$result['tag_id'] = 'ptt_result';
		$result['data'] = $return;
	}

	


}
catch (Exception $e) {
	
}
die( json_encode( $result ) );
?>