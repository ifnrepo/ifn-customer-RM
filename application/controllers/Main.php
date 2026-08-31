<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getauthcrm') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('produk_model','produkmodel');
        $this->load->model('usermodel');

		$this->load->library('pagination');
    }
	public function index()
	{
		$header['header'] = [
			'menu' => 'dashboard'
		];
		$this->load->view('layouts/header',$header);
		$this->load->view('main');
		$this->load->view('layouts/footer');
	}
}
