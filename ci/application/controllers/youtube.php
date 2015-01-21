<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class youtube extends CI_Controller {

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
		$base_url = base_url();
		$youtube_url = safe_uri ($this->input->get('youtube_url'));
		$sys['meta_og'] = array(
		'title'			=> 'youtube 播放器',
		'description'	=> 'youtube 播放器，將網頁內的youtube網址抓出來，依序播放。',
		'url'			=> $base_url . 'youtube',
		'image'			=> $base_url . 'img/og.jpg',
		'type'			=> 'website',
		'keywords'		=> 'youtube',
		);

		$var = array();
		$var['youtube_url'] = $youtube_url;
		$var['html_youtube'] = safe_nobr(safe_notags($this->get_youtube($youtube_url)));


		//print_r($this->config);
		$this->load->view('header' , array(
			'title' => 'youtube 播放器',
			'head' => meta_og($sys['meta_og']),
		));
		$this->load->view('top_menu' , array(
			'nav' => $this->config->item('my_route'),
			'current' => $this->uri->segment(1), // 現在在哪頁
		));
		$this->load->view('youtube');
		$this->load->view('footer' , array(
			'js' => $this->load->view('js/youtube' , $var , true),
		));
	}

	public function get_youtube($youtube_url){
		if($youtube_url){
			$this->load->library('curl');
			$vars = array('over18'=>'1');
			$this->curl->create($youtube_url);
			$this->curl->set_cookies($vars);
			return $this->curl->execute();
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */