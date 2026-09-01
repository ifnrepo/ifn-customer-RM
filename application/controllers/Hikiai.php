<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hikiai extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getauthcrm') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('hikiaimodel');
        $this->load->model('usermodel');

		$this->load->library('pagination');
    }
	public function index()
	{
		$header['header'] = [
			'menu' => 'hikiai'
		];
		$data['data'] = [
		];
		$footer['footer'] = [
			'menu' => 'hikiai'
		];

		$this->load->view('layouts/header',$header);
		$this->load->view('hikiai/hikiai',$data);
		$this->load->view('layouts/footer',$footer);
	}
	public function clear(){
		$this->session->unset_userdata('kode-hikiai');
		$this->session->set_userdata('bulan-hik',date('m'));
		$this->session->set_userdata('tahun-hik',date('Y'));
		$url = base_url().'hikiai';
		redirect($url);
	}
	public function addsession(){
		$tipe = isset($_POST['tipe']) ? $_POST['tipe'] : 0;
		if($tipe!=0){
			$this->session->set_userdata('kode-hikiai',$tipe);
		}else{
			$this->session->unset_userdata('kode-hikiai');
		}
		echo 1;
	}
	public function tambahdata(){
		$this->load->view('hikiai\addhikiai');
	}
	public function getdatacustomer(){
		$kode = $_POST['isi'];
		$data = $this->hikiaimodel->getdatacustomer($kode);
		$html = '';
		if($data->num_rows() > 0){ $no=0;
			foreach($data->result_array() as $dt): $no++;
				$html .= '<tr>';
				$html .= '<td>#'.$no.'</td>';
				$html .= '<td class="font-kecil line-11"><span class="text-pink font-10">'.$dt['kode_customer'].'</span><br>'.$dt['buyer'].'-'.$dt['port'].'</td>';
				$html .= '<td class="font-kecil">'.$dt['alamat'].'</td>';
				$html .= '<td class="text-center">';
				$html .= '<a href="#" class="btn btn-success p-0 btn-flat font-kecil" id="pilihcustomer" rel="'.$dt['id'].'">Pilih</a>';
				$html .= '</td>';
				$html .= '</tr>';
			endforeach;
		}
		$send = array('data' => $html, 'jml' => $data->num_rows());
		echo json_encode($send);
	}
}
