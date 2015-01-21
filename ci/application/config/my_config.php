<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['my_route'] = array(
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

	'mj' => array(
		'name' => '麻將 紀錄',
		'nav' => true , // 顯示在上面選單
	),

	'ajax' => array(
		'name' => 'ajax',
		'nav' => false,
	),
);

//fb應用程式的id
$config['fb_id'] = '482845198525908';
?>