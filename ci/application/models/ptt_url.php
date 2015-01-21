<?php
class Ptt_url extends CI_Model {
	
	// 抓db幾秒內的資料
	var $time_over_secs = 60;

    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
		$this->load->database();
    }
    
    function get_from_db($ptt_url)
    {
        $this->db->select('ptt_url , content')->from('ptt_url_ci')->where('ptt_url', $ptt_url)->where('time >', now( time() - $this->time_over_secs ));
		return $this->db->get()->row_array();
    }

    function replace_into_db($ptt_url , $json)
    {
        $data = array('ptt_url' => $ptt_url , 'time' => now() , 'content' => serialize($json));
		return $this->db->replace('ptt_url_ci' , $data);
    }
}
?>