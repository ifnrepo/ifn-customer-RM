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
		$config['base_url'] = base_url().'hikiai/index'; // The URL to your controller method
        $config['total_rows'] = $this->hikiaimodel->countdata(); // Total records in your table
        $config['per_page'] = $this->session->userdata('perpage-hikiai')=='' ? 15 : $this->session->userdata('perpage-hikiai'); // Records per page
        $config['uri_segment'] = 3; // Which URL segment contains the page number
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$header['header'] = [
			'menu' => 'hikiai'
		];
		$data = [
			'data' => $this->hikiaimodel->getdata($config['per_page'],$page),
			'jumlahrek' => $this->hikiaimodel->countdata(),
			'links' => $this->pagination->create_links()
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
		$bulan = isset($_POST['bul']) ? $_POST['bul'] : date('m');
		$tahun = isset($_POST['tah']) ? $_POST['tah'] : date('Y');
		if($tipe!=0){
			$this->session->set_userdata('kode-hikiai',$tipe);
		}else{
			$this->session->unset_userdata('kode-hikiai');
		}
		$this->session->set_userdata('bulan-hik',$bulan);
		$this->session->set_userdata('tahun-hik',$tahun);
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
				$html .= '<td class="font-kecil line-11"><span class="text-pink font-10">'.$dt['kode_customer'].'</span><br>'.trim($dt['buyer']).'-'.$dt['port'].'</td>';
				$html .= '<td class="font-kecil">'.$dt['alamat'].'</td>';
				$html .= '<td class="text-center">';
				$html .= '<a href="#" class="btn btn-success p-0 btn-flat font-kecil" id="pilihcustomer" rel="'.$dt['id'].'" rel2="'.trim($dt['buyer']).'-'.$dt['port'].'" rel3="'.trim($dt['alamat']).'">Pilih</a>';
				$html .= '</td>';
				$html .= '</tr>';
			endforeach;
		}
		$send = array('data' => $html, 'jml' => $data->num_rows());
		echo json_encode($send);
	}
	public function getdataproduk(){
		$kode = $_POST['isi'];
		$data = $this->hikiaimodel->getdataproduk($kode);
		$html = '';
		if($data->num_rows() > 0){ $no=0;
			foreach($data->result_array() as $dt): $no++;
				$html .= '<tr>';
				$html .= '<td>#'.$no.'</td>';
				$html .= '<td class="font-kecil line-11"><span class="text-pink font-10">'.$dt['kode'].'</span><br>'.trim($dt['spesifikasi']).'</td>';
				$html .= '<td class="font-kecil">'.$dt['nama_kategori'].'</td>';
				$html .= '<td class="text-center">';
				$html .= '<a href="#" class="btn btn-success p-0 btn-flat font-kecil" id="pilihproduk" rel="'.$dt['id'].'" rel2="'.trim($dt['spesifikasi']).'" rel3="'.trim($dt['nama_kategori']).'">Pilih</a>';
				$html .= '</td>';
				$html .= '</tr>';
			endforeach;
		}
		$send = array('data' => $html, 'jml' => $data->num_rows());
		echo json_encode($send);
	}
	public function simpanhikiai(){
		$data = [
			'kode' => strtoupper($_POST['kode']),
			'tgl_hikiai' => tglmysql($_POST['tgl']),
			'nomor' => strtoupper($_POST['nomor']),
			'id_customer' => $_POST['idc'],
			'perihal' => trim($_POST['peri']),
			'kepada' => trim($_POST['kepa']),
			'remark' => trim($_POST['kete']),
			'dibuat_oleh' => $this->session->userdata('id'),
			'exdo' => $this->session->userdata('kode-hikiai')
		];
		$qry = $this->hikiaimodel->simpanhikiai($data);
		echo $qry;
	}
	public function simpandatahikiai($id){
		$qry = $this->hikiaimodel->simpandatahikiai($id);
		if($qry){
			$url = base_url().'hikiai';
			redirect($url);
		}
	}
	public function edithikiai($id){
		$header['header'] = [
			'menu' => 'hikiai'
		];
		$data = [
			'data' => $this->hikiaimodel->getdatabyid($id),
			'datadetail' => $this->hikiaimodel->getdatadetail($id)
		];
		$footer['footer'] = [
			'menu' => 'hikiai'
		];
		$this->load->view('layouts/header',$header);
		$this->load->view('hikiai/edithikiai',$data);
		$this->load->view('layouts/footer',$footer);
	}
	public function hapushikiai($id){
		$qry = $this->hikiaimodel->hapushikiai($id);
		if($qry){
			$url = base_url().'hikiai';
			redirect($url);
		}
	}
	public function adddetailhikiai($id){
		$data = [
			'satuan' => $this->hikiaimodel->getsatuan()
		];
		$this->load->view('hikiai\adddetailhikiai',$data);
	}
	public function editdetailhikiai($id){
		$data = [
			'data' => $this->hikiaimodel->getdetailhikiaibyid($id),
			'satuan' => $this->hikiaimodel->getsatuan()
		];
		$this->load->view('hikiai\editdetailhikiai',$data);
	}
	public function simpandetailhikiai(){
		$data = [
			'id_hikiai' => $_POST['idhik'],
			'id_produk' => $_POST['idprod'],
			'pcs' => toAngka($_POST['pcs']),
			'kgs' => toAngka($_POST['kgs']),
			'keterangan' => $_POST['kete'],
			'id_satuan' => $_POST['sat']
		];
		$qry = $this->hikiaimodel->simpandetailhikiai($data);
		echo $qry;
	}
	public function updatedetailhikiai(){
		$data = [
			'id' => $_POST['id'],
			'id_produk' => $_POST['idprod'],
			'pcs' => toAngka($_POST['pcs']),
			'kgs' => toAngka($_POST['kgs']),
			'keterangan' => $_POST['kete'],
			'id_satuan' => $_POST['sat']
		];
		$qry = $this->hikiaimodel->updatedetailhikiai($data);
		echo $qry;
	}
	public function hapusdetailhikiai($id,$hd){
		$qry = $this->hikiaimodel->hapusdetailhikiai($id);
		if($qry){
			$url = base_url().'hikiai/edithikiai/'.$hd;
			redirect($url);
		}
	}
	public function editbatalhikiai($id){
		$qry = $this->hikiaimodel->editbatalhikiai($id);
		if($qry){
			$url = base_url().'hikiai/edithikiai/'.$id;
			redirect($url);
		}
	}
	public function resetdetailhikiai($id){
		$qry = $this->hikiaimodel->resetdetailhikiai($id);
		if($qry){
			$url = base_url().'hikiai/edithikiai/'.$id;
			redirect($url);
		}
	}
	public function viewdetail($id){
		$data = [
			'data' => $this->hikiaimodel->getdatabyid($id),
			'datadetail' => $this->hikiaimodel->getdatadetail($id)
		];
		$this->load->view('hikiai\viewdetail',$data);
	}
	public function kirimppic($id){
		$qry = $this->hikiaimodel->kirimppic($id);
		if($qry){
			$url = base_url().'hikiai';
			redirect($url);
		}
	}
	public function addremark($id,$hik){
		$data = [
			'idrem' => $id,
			'idhik' => $hik,
			'data' => $this->hikiaimodel->getremarkbyid($id,$hik)
		];
		$this->load->view('hikiai\addremark',$data);
	}
	public function simpanremarkhikiai(){
		$data = [ 
			'idhik' => $_POST['idhik'],
			'idrem' => $_POST['idrem'],
			'judul' => strtoupper($_POST['rem']),
			'isi' => $_POST['teks']
		];

		echo $this->hikiaimodel->simpanremarkhikiai($data);
	}
}
