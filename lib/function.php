<?php
//var_dump(__DIR__);
$base_url = 'http://z358z358.pcro.co';

require __DIR__ . '/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem( __DIR__ . '/../view');
$twig = new Twig_Environment($loader, array(
	'cache' => __DIR__ . '/cache',
	'auto_reload' => true,
));

$_route = array(
	'main' => array(
		'name' => 'main',   // 首頁
		'nav' => false , // 不顯示在上面選單
	),
	
	'ptt' => array(
		'name' => '推文',
		'nav' => true , // 顯示在上面選單
	),

	'youtube' => array(
		'name' => 'youtube播放',
		'nav' => true , // 顯示在上面選單
	),

	'ajax' => array(
		'name' => 'ajax',
		'nav' => false,
	),
	
);


// 切url
$url = explode('/', substr($_SERVER['REQUEST_URI'], 1));
$db = 'z358z358_ptt';

//fb應用程式的id
$fb_id = '482845198525908';


//$sql = "SELECT * FROM `test` WHERE 1";
//echo '<pre>';
//var_dump(sql_get_array( db($db) , $sql ));
//echo '</pre>';
//$html['bodyer'] .= sql_get_array( db($db) , $sql );
//$html['bodyer'] = var_dump($url);
function db( $db_name ){
	$db = mysql_connect( 'localhost' , 'z358z358_zaaaaa' , '7beTg0o4V8' , true );
	if($db){
		mysql_select_db( $db_name , $db );
		return $db;
	}

}

//  取得唯一一個值 / 找不到資料傳回 false
//   ex.   $val = sql_get_val($db, "select `username` from Table where `pri_key` = '...'")
function sql_get_val($db, $query) {
	if( !$db || !$query ) return false;
	$res = sql($db, $query);
	if (!$res || mysql_num_rows($res) == 0) return false;
	return mysql_result($res, 0);

}

//  取得多個值 / 找不到資料傳回 array()
//   ex.   list($name, $sex, $age) = sql_get_vals($db, "select `name`, `sex`, `age` from Table where `pri_key` = '...'")
function sql_get_vals($db, $query) {
	if( !$db || !$query ) return array();
	$res = sql($db, $query);
	if (!$res || mysql_num_rows($res) == 0) return array();
	return mysql_fetch_array($res, MYSQL_NUM);
}

//  取得一整列 / 找不到資料傳回 array()
//   ex.   $row = sql_get_row($db, "select * from Table where `pri_key` = '...'")
function sql_get_row($db, $query) {
	if( !$db || !$query ) return array();
	$res = sql($db, $query);
	if (!$res || mysql_num_rows($res) == 0)	return array();
	return mysql_fetch_assoc($res);
}

//  取得多筆資料的單一欄位構成的陣列 / 錯誤傳回 false / 找不到資料傳回空陣列
//   ex.   $user_no_list = sql_get_row($db, "select `user_no` from Table where `pri_key` < 10")
//        傳回值會是每行 user_no 構成的 array(1, 2, 3, 4, 5)
function sql_get_list($db, $query) {
	if( !$db || !$query ) return array();
	$res = sql($db, $query);
	if (!$res) return array();
	$arr = array();
	while ($tmp = mysql_fetch_array($res)) {
		$arr[] = $tmp[0];
	}
	return $arr;
}

//  取得多筆資料構成的二維陣列 (內層是聯想陣列ASSOC) / 錯誤傳回 false / 找不到資料傳回空陣列
//   ex.   $user_list = sql_get_array($db, "select * from Table where `pri_key` < 10")
//        傳回值會是 array( array(...), array(...), ... )
function sql_get_array($db, $query) {
	if( !$db || !$query ) return array();
	$res = sql($db, $query);
	if (!$res) return false;
	$arr = array();
	while ($tmp = mysql_fetch_assoc($res)) {
		$arr[] = $tmp;
	}
	return $arr;
}

//  取得多筆資料構成的聯想二維陣列 / 錯誤傳回 false / 找不到資料傳回空陣列
//    $akey : 作為陣列鍵值的欄位
//    $vkey : 當value只有一筆時，指定value的欄位名 則傳回一維陣列
//
//   ex.   $user_list = sql_get_hash($db, "select * from Table where `pri_key` < 10", 'user_name')
//        傳回值會是 array( 'but' => array(...), 'tony' => array(...), ... )
//
//   ex.   $user_list = sql_get_hash($db, "select `user_no`, `user_name` from Table where `pri_key` < 10", 'user_name', 'user_no')
//        傳回值會是 array( 'but' => 5, 'tony' => 3, ... )
//
function sql_get_hash($db, $query, $akey, $vkey = NULL) {
	$res = sql($db, $query);
	if (!$res) return array();

	$arr = array();
	while ($tmp = mysql_fetch_assoc($res)) {
		if ($vkey)
			$arr[$tmp[$akey]] = $tmp[$vkey];
		else
			$arr[$tmp[$akey]] = $tmp;
	}
	return $arr;
}

//  取得多筆資料構成的聯想二維陣列 / 找不到資料傳回 false
//  自動以每筆第一個值作為陣列鍵 第二個值作為值
//
//   ex.   $user_list = sql_get_pairs($db, "select `user_no`, `user_name` from Table where `pri_key` < 10")
//        傳回值會是 array( 'but' => 5, 'tony' => 3, ... )
//
function sql_get_pairs($db, $query) {
	$res = sql($db, $query);
	if (!$res) return array();

	$arr = array();
	while ($tmp = mysql_fetch_array($res)) {
		$arr[$tmp[0]] = $tmp[1];
	}
	return $arr;
}

function sql($db, $query) {
	if( !$db || !$query ) return false;

	if ($res = mysql_query($query, $db)) {
		return $res;
	}
	return false;
}


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

//
function get_ptt($ptt_url = ''){
	global $db;
	
	// 先去sql找
	$sql = "SELECT `ptt_url` , `content` FROM `ptt_url` WHERE `ptt_url` = '" . $ptt_url . "' AND `time` > '" . now( time() - 60 ) . "'";
	$t = sql_get_row(db($db) , $sql);
	if($t){
		//var_dump($t);
		$tmp = unserialize($t['content']);
		$tmp['ptt_url'] = $t['ptt_url'];
		return $tmp;
	}


	$return_html = curl_get_url($ptt_url , 'over18=1');
	

	preg_match_all('#<div class="push"><span class="(.*?)">(.*?)</span><span class="(.*?)">(.*?)</span><span class="(.*?)">(.*?)</span><span class="(.*?)">(.*?)</span></div>#sm', $return_html, $match); 
	
	$floor = 1;
	$json = array();
	preg_match("/<title>(.+)<\/title>/siU", $return_html, $matches);
	$json['title'] = $matches[1];
	$json['ptt_url'] = $ptt_url;

	// 2 推噓箭頭 4 id 6 內容 8 時間(沒年分)和ip
	foreach($match[4] as $ptt_id){
		$array_no = $floor - 1;

		$json['push'][$floor]['id'] = safe_word($ptt_id);
		$json['push'][$floor]['type'] = str_replace(' ', '', $match[2][$array_no]);

		// 刪掉冒號空白
		if(substr($match[6][$array_no] , 0 , 2) == ': '){
			$json['push'][$floor]['content'] = substr($match[6][$array_no] , 2);
		}
		else if(substr($match[6][$array_no] , 0 , 1) == ':'){
			$json['push'][$floor]['content'] = substr($match[6][$array_no] , 1);
		}
		else{
			$json['push'][$floor]['content'] = $match[6][$array_no];
		}

		//  如果有ip的話
		if(strrpos($match[8][$array_no], '.') !== false){
			$m = sscanf($match[8][$array_no], "%s %d/%d %d:%d");
		}
		else{
			$m = sscanf($match[8][$array_no], "%d/%d %d:%d");
			// 補空白ip
			array_unshift($m, '');
		}
		$json['push'][$floor]['ip'] = $m[0];
		$json['push'][$floor]['month'] = str_pad($m[1],2,'0',STR_PAD_LEFT);
		$json['push'][$floor]['day'] = str_pad($m[2],2,'0',STR_PAD_LEFT);
		$json['push'][$floor]['hour'] = str_pad($m[3],2,'0',STR_PAD_LEFT);
		$json['push'][$floor]['mins'] = str_pad($m[4],2,'0',STR_PAD_LEFT);

		$floor++;

	}

	// 塞回db
	$sql = "REPLACE INTO `ptt_url`(`ptt_url`, `time`, `content`) 
	VALUES ('" . $ptt_url . "','" . now() . "','" . serialize($json) . "')";
	sql(db($db) , $sql);

	//var_dump($json);
	return $json;

}
?>