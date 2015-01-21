<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ajax extends CI_Controller {

	 public function __construct()
    {
        parent::__construct();
		$this->load->library('curl');
		//$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file'));
    }

	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$result = array();
		$result['debug'] = $this->input->post('post_type');
		switch($this->input->post('post_type')){
			// ptt網址
			case 'ptt':
				$result['type'] = 'ptt_table';
				$ptt_url = safe_uri ($this->input->post('ptt_url'));
				// 網址沒傳 或不是ptt
				if(!$ptt_url || strrpos($ptt_url, 'www.ptt.cc/bbs/') === false){
					$result['type'] = 'input_error';
					$result['tag_id'] = 'ptt_url';
					break;
				}
				
				$result['tag_id'] = 'ptt_result';
				$result['data'] = $this->get_ptt($ptt_url);
			break;

			default:
			break;

		}
		echo json_encode( $result );	
	}

	public function get_ptt($ptt_url)
	{
		$this->load->model('ptt_url');
		$t = $this->ptt_url->get_from_db($ptt_url);

		
		//$t = $this->cache->get($ptt_url);

		if($t){
			//var_dump($t);
			$tmp = unserialize($t['content']);
			$tmp['ptt_url'] = $t['ptt_url'];
			return $tmp;
		}

		$vars = array('over18'=>'1');
		$this->curl->create($ptt_url);
		$this->curl->set_cookies($vars);
		$return_html = $this->curl->execute();
		

		preg_match_all('#<div class="push"><span class="(.*?)">(.*?)</span><span class="(.*?)">(.*?)</span><span class="(.*?)">(.*?)</span><span class="(.*?)">(.*?)</span></div>#sm', $return_html, $match); 
		
		$floor = 1;
		$json = array();
		preg_match("/<title>(.+)<\/title>/siU", $return_html, $matches);
		$json['title'] = $matches[1];
		$json['ptt_url'] = $ptt_url;

		// 2 推噓箭頭 4 id 6 內容 8 時間(沒年分)和ip
		foreach($match[4] as $ptt_id){
			$array_no = $floor - 1;
			$tmp = array('floor' => $floor);

			//$json['push'][$floor]['floor'] = $floor;
			$tmp['id'] = safe_word($ptt_id);
			$tmp['type'] = str_replace(' ', '', $match[2][$array_no]);

			// 刪掉冒號空白
			if(substr($match[6][$array_no] , 0 , 2) == ': '){
				$tmp['content'] = substr($match[6][$array_no] , 2);
			}
			else if(substr($match[6][$array_no] , 0 , 1) == ':'){
				$tmp['content'] = substr($match[6][$array_no] , 1);
			}
			else{
				$tmp['content'] = $match[6][$array_no];
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
			$tmp['ip'] = $m[0];
			$tmp['month'] = str_pad($m[1],2,'0',STR_PAD_LEFT);
			$tmp['day'] = str_pad($m[2],2,'0',STR_PAD_LEFT);
			$tmp['hour'] = str_pad($m[3],2,'0',STR_PAD_LEFT);
			$tmp['mins'] = str_pad($m[4],2,'0',STR_PAD_LEFT);

			$json['push'][] = $tmp;

			$json['google_chart'][$tmp['type']]++;

			$floor++;

		}

		// 塞回db
		$this->ptt_url->replace_into_db($ptt_url , $json);

		// 塞cache
		//$this->cache->save($ptt_url , $data , 60);

		//var_dump($json);
		return $json;

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */