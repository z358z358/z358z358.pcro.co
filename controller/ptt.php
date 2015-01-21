<?php
$html['title'] = 'Ptt推文計算機';
$sys['meta_og'] = array(
'title'			=> 'Ptt推文計算機',
'description'	=> 'Ptt推文計算機，只需要填入Ptt網頁版網址，就可以輕鬆知道推文位於第幾樓，也可以只看推文、噓文、箭頭。',
'url'			=> $base_url . '/ptt',
'image'			=> $base_url . '/img/og.jpg',
'type'			=> 'website',
'keywords'		=> 'ptt,推文,計算機,噓文,箭頭,樓,幾樓,推文計算機',
);

//$sql = "SELECT * FROM `ptt_url`";
//var_dump(sql_get_array(db($db) , $sql));
$html['css_lib'] = meta_og($sys['meta_og']);
echo $twig->render('ptt.html', $html );

?>