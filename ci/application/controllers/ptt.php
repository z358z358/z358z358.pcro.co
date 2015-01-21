<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ptt extends CI_Controller {

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
		//$this->output->cache(60);
		$base_url = base_url();
		$html['title'] = 'Ptt推文計算機';
		$sys['meta_og'] = array(
		'title'			=> 'Ptt推文計算機',
		'description'	=> 'Ptt推文計算機，只需要填入Ptt網頁版網址，就可以輕鬆知道推文位於第幾樓，也可以只看推文、噓文、箭頭。',
		'url'			=> $base_url . 'ptt',
		'image'			=> $base_url . 'img/og.jpg',
		'type'			=> 'website',
		'keywords'		=> 'ptt,推文,計算機,噓文,箭頭,樓,幾樓,推文計算機',
		);


		//print_r($this->config);
		$this->load->view('header' , array(
			'title' => 'Ptt推文計算機',
			'head' => meta_og($sys['meta_og']),
		));
		$this->load->view('top_menu' , array(
			'nav' => $this->config->item('my_route'),
			'current' => $this->uri->segment(1), // 現在在哪頁
		));
		$this->load->view('ptt');
		$this->load->view('footer' , array(
			'js' => $this->load->view('js/ptt' , '' , true),
		));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */