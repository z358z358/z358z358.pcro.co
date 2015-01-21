<?php
$html['title'] = 'youtube 播放器';
$sys['meta_og'] = array(
'title'			=> 'youtube 播放器',
'description'	=> 'youtube 播放器，將網頁內的youtube網址抓出來，依序播放。',
'url'			=> $base_url . '/youtube',
'image'			=> $base_url . '/img/og.jpg',
'type'			=> 'website',
'keywords'		=> 'youtube',
);

$html['youtube_url'] = safe_uri($_GET['youtube_url']);
if($html['youtube_url']){
	$html['html_youtube'] = curl_get_url($html['youtube_url'] , 'over18=1');
}

//$sql = "SELECT * FROM `ptt_url`";
//var_dump(sql_get_array(db($db) , $sql));
$html['css_lib'] = meta_og($sys['meta_og']);
echo $twig->render('youtube.html', $html );

?>