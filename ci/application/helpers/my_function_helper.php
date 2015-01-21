<?php
//
//	增加 fb og tag
//
function meta_og( $arr ) {
	//$fb_app_id = ($arr['fb_app_id']) ? $arr['fb_app_id'] : 123895894363397;
	//unset($arr['fb_app_id']);
	$meta .= '<meta property="og:locale" content="zh_tw" />';
	foreach( (array)$arr as $type => $content ) {
		if( $content ) $meta .= '<meta name="fb_' . $type . '" property="og:' . $type . '" content="' . $content . '" />';
	}
	$meta .= '<meta name="description" content="' . $arr['description'] . '">';
	$meta .= '<meta name="keywords" content="' . $arr['keywords'] . '">';

	return $meta;
}

//	數字 (整數)
function safe_int( $str ) { return intval( $str );}
//	數字 (含小數點)
function safe_double( $str ) { return doubleval( $str );}
//	數字 (含逗點) , $res 不用傳
function safe_int_dot( $str , $res = array() ) {
	foreach (explode(',', $str) as $n) $res[] = intval($n);
	return implode(',', $res);
}
//	純數字 可0開頭
function safe_num( $str ) { return preg_replace("/[^0-9]/", "", $str);}
//	純英文
function safe_eng( $str ) { return preg_replace("/[^a-zA-Z]/", "", $str);}
//	判斷帳號是否合法 含底線英文+數字 ( 防止以後增加其他需求用 )
function safe_id( $str ) { return preg_replace("/[^a-zA-Z0-9_-]/", "", $str);}
//	含底線英文+數字
function safe_word( $str ) { return preg_replace("/[^a-zA-Z0-9_]/", "", $str);}
//	文字 (轉換HTML)
function safe_text( $str ) { return addslashes( htmlspecialchars( $str , ENT_QUOTES ) );}
//	文字 (過濾HTML)
function safe_notags( $str ) { return addslashes( htmlspecialchars( strip_tags( $str ) ) );}
//	文字 (過濾 多餘空白 TAB 斷行 ) ( 需注意 textarea 與 javascript )
function safe_nobr( $str ) { return trim( preg_replace('/[ \t\n\r]+/', ' ', $str) ); }
//	文字 (保留HTML)
function safe_html( $str ) { return addslashes( $str );}
//	日期 xxxx-xx-xx
function safe_date( $str ) { return date( 'Y-m-d', strtotime( $str ) ); }
//	日期+時間 xxxx-xx-xx xx:xx:xx
function safe_datetime( $str ) { return date( 'Y-m-d H:i:s', strtotime( $str ) ); }
//	array (轉換HTML)
function safe_json_encode( $ary ) { return safe_text( json_encode( $ary ) ); }
//	解array (可能有危險HTML)
function safe_json_decode( $str ) { return json_decode( htmlspecialchars_decode( $str , ENT_QUOTES ) , true ); }
//解決sql injection與資料內單雙引號問題,$dont_auto_quotes = 'yes';
function safe_array_encode( $ary ) { return addslashes( serialize( $ary ) ); }
//解array(解後會有危險HTML)
function safe_array_decode( $ary ) { return unserialize( stripslashes( $ary ) ); }
//	IP (錯誤或空的會回傳空白 )
function safe_ip( $ip ) { return filter_var($ip, FILTER_VALIDATE_IP);}

// 檢查 Email 位址是否符合規格 (符合傳回 Email 本身, 不符合傳回 false)
function safe_email( $email ) {	return filter_var($email, FILTER_VALIDATE_EMAIL);}

// 檢查 URI 是否符合規格 (符合傳回 URI 本身, 不符合傳回 false)
function safe_uri ($uri) {	return filter_var($uri, FILTER_VALIDATE_URL);}

//
//	利用crul抓網頁的資料  可送post  可存cookie
//	範例:
//	$bot_name = 'bot_cookie';	//	設定bot的cookie名稱 不能重複
//	$url = 'http://www.gamebase.com.tw/login.php';
//	$postdata = 'type=login&login_id=abc123&login_ps=123456';
//	$ourl = 'http://www.gamebase.com.tw/login.php';	//	用在post後會轉到其他頁面用
//	$useragent = 'google bot';	//	可以自己帶
//  $proxy = '219.85.64.xxx' // 如果不要用proxy就給false。用proxy的話ip會變.250
//
function curl_get_url( $url , $cookie_content = false , $postdata = false , $ourl = false , $useragent = false , $referer = false, $proxy = false , $timeout = 5 ) {
	if( !$url ) return;
	//if( $bot_name ) $cookie_file = '/net/srv/tmp/bot/' . $bot_name . '.cookie';
	if( !$timeout ) $timeout = 5;
	//if( !$useragent ) $useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	if ( !$useragent ) $useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20120403211507 Firefox/12.0';

	$rs = curl_init();
	if($referer) curl_setopt($rs,CURLOPT_REFERER,$referer);
	curl_setopt($rs, CURLOPT_URL, $url);
	curl_setopt($rs, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($rs, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($rs, CURLOPT_USERAGENT, $useragent);
	if($proxy) {
		curl_setopt($rs, CURLOPT_HTTPPROXYTUNNEL, TRUE);
        curl_setopt($rs, CURLOPT_PROXY, $proxy);
	}
	//	如果有要 POST 資料  格式 type=login&login_id=gb_tony
	if( $postdata ) {
		curl_setopt($rs, CURLOPT_POST, 1);
		curl_setopt($rs, CURLOPT_POSTFIELDS, $postdata);
	}
	if($cookie_content){
		curl_setopt($rs, CURLOPT_COOKIE, $cookie_content);
	}
	curl_setopt($rs, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($rs, CURLOPT_FOLLOWLOCATION, 1);
	$html = curl_exec($rs);
	if( $ourl ) {
		curl_setopt($rs, CURLOPT_URL, $url);
		$html = curl_exec($rs);
	}
	curl_close($rs);
	return $html;
}

//	現在 now()
function now( $time = '' ) { return date('Y-m-d H:i:s', $time ? $time : time() ); }

?>