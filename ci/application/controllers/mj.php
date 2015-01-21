<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mj extends CI_Controller {

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
		$sys['meta_og'] = array(
		'title'			=> 'youtube 播放器',
		'description'	=> 'youtube 播放器，將網頁內的youtube網址抓出來，依序播放。',
		'url'			=> $base_url . 'youtube',
		'image'			=> $base_url . 'img/og.jpg',
		'type'			=> 'website',
		'keywords'		=> 'youtube',
		);

		//print_r($this->config);
		$this->load->view('header' , array(
			'title' => '麻將紀錄',
			'head' => meta_og($sys['meta_og']),
		));
		$this->load->view('top_menu' , array(
			'nav' => $this->config->item('my_route'),
			'current' => $this->uri->segment(1), // 現在在哪頁
		));
		$this->load->view('mj');
		$this->load->view('footer' , array(
			'js' => $this->load->view('js/mj' , '' , true),
		));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */