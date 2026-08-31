<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getauthcrm') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
		$this->load->model('usermodel');
        $this->load->model('produk_model','produkmodel');

		$this->load->library('pagination');
    }
	public function index()
	{
		$config['base_url'] = base_url().'produk/index'; // The URL to your controller method
        $config['total_rows'] = $this->produkmodel->countdata(); // Total records in your table
        $config['per_page'] = $this->session->userdata('perpage-produk')=='' ? 15 : $this->session->userdata('perpage-produk'); // Records per page
        $config['uri_segment'] = 3; // Which URL segment contains the page number
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$header['header'] = [
			'menu' => 'master'
		];
		$data = [
			'katproduk' => $this->produkmodel->getkatproduk(),
			'jnnet' => $this->produkmodel->netornot(0),
			'kodenet' => $this->produkmodel->netornot(1),
			'data' => $this->produkmodel->getdata($config['per_page'],$page)
		];
		$footer['footer'] = [
			'menu' => 'produk'
		];

		$data['jumlahrek'] = $this->produkmodel->countdata();
        $data['links'] = $this->pagination->create_links();

		$this->load->view('layouts/header',$header);
		$this->load->view('produk/produk',$data);
		$this->load->view('layouts/footer',$footer);
	}
	public function clear(){
		$this->session->unset_userdata('select-tipe');
		$url = base_url().'produk';
		redirect($url);
	}
	public function addsession(){
		$kode = isset($_POST['tipe']) ? $_POST['tipe'] : '';
		$page = isset($_POST['page']) ? $_POST['page'] : '';
		if($kode==''){
			$this->session->unset_userdata('select-tipe');
		}else{
			$this->session->set_userdata('select-tipe',$kode);
		}
		if($page==''){
			$this->session->unset_userdata('perpage-produk');
		}else{
			$this->session->set_userdata('perpage-produk',$page);
		}
		echo 1;
	}
	public function addproduk(){
		$data = [
			'jns_benang' => $this->produkmodel->getjenisbenang(),
			'getcolor' => $this->produkmodel->getcolor()
		];
		$this->load->view('produk/addproduk',$data);
	}
	public function getukuranbenang(){
		$jns = $_POST['tipe'];
		$isi = $_POST['isi'];
		$data = $this->produkmodel->getukuranbenang($jns);
		$html = '<option value="">-- Ukuran Benang --</option>';
		if($data->num_rows() > 0){
			foreach($data->result_array() as $xdata){
				$selek = trim($xdata['ukuran'])==trim($isi) ? 'selected' : '';
				$html .= '<option value="'.$xdata['ukuran'].'" '.$selek.'>'.$xdata['ukuran'].'</option>';
			}
		}
		$cocok = ['hasil' => $html];
		echo json_encode($cocok);
	}
	public function simpanjala(){
		$data = [
			'kategori_id' => $_POST['ctgrid'],
			'knot' => $_POST['knot'],
			'kode' => $_POST['kode'],
			'jenis_benang' => $_POST['jenben'],
			'ukuran_benang' => $_POST['ukrben'],
			'meai' => $_POST['meai'],
			'ukuran_meai' => $_POST['stmeai'],
			'mesh' => $_POST['mesh'],
			'length' => $_POST['len'],
			'st_length' => $_POST['satlen'],
			'color' => $_POST['color'],
			'ways' => $_POST['ways'],
			'keterangan' => $_POST['ket'],
			'spesifikasi' => $_POST['spek']
		];
		$qry = $this->produkmodel->simpanjala($data);
		echo $qry;
	}
	public function editjala(){
		$data = [
			'id' => $_POST['id'],
			'kategori_id' => $_POST['ctgrid'],
			'knot' => $_POST['knot'],
			'kode' => $_POST['kode'],
			'jenis_benang' => $_POST['jenben'],
			'ukuran_benang' => $_POST['ukrben'],
			'meai' => $_POST['meai'],
			'ukuran_meai' => $_POST['stmeai'],
			'mesh' => $_POST['mesh'],
			'length' => $_POST['len'],
			'st_length' => $_POST['satlen'],
			'color' => $_POST['color'],
			'ways' => $_POST['ways'],
			'keterangan' => $_POST['ket'],
			'spesifikasi' => $_POST['spek']
		];
		$qry = $this->produkmodel->editjala($data);
		echo $qry;
	}
	public function simpanother(){
		$data = [
			'kategori_id' => $_POST['ctgrid'],
			'produk' => $_POST['produk'],
			'kode' => $_POST['kode'],
			'ukuran_benang' => strtoupper($_POST['ukrben']),
			'tipe_oth' => strtoupper($_POST['tipe']),
			'package_oth' => strtoupper($_POST['pack']),
			'color' => $_POST['color'],
			'keterangan' => $_POST['ket'],
			'spesifikasi' => $_POST['spek']
		];
		$qry = $this->produkmodel->simpanjala($data);
		echo $qry;
	}
	public function editother(){
		$data = [
			'id' => $_POST['id'],
			'kategori_id' => $_POST['ctgrid'],
			'kategori_id' => $_POST['ctgrid'],
			'produk' => $_POST['produk'],
			'kode' => $_POST['kode'],
			'ukuran_benang' => strtoupper($_POST['ukrben']),
			'tipe_oth' => strtoupper($_POST['tipe']),
			'package_oth' => strtoupper($_POST['pack']),
			'color' => $_POST['color'],
			'keterangan' => $_POST['ket'],
			'spesifikasi' => $_POST['spek']
		];
		$qry = $this->produkmodel->editjala($data);
		echo $qry;
	}
	public function hapusdata($id){
		$hasil = $this->produkmodel->hapusdata($id);
		if($hasil){
			$url = base_url().'produk';
			redirect($url);
		}
	}
	public function editdata($id){
		$data = [
			'jns_benang' => $this->produkmodel->getjenisbenang(),
			'getcolor' => $this->produkmodel->getcolor(),
			'data' => $this->produkmodel->getprodukbyid($id)
		];
		$this->load->view('produk/editproduk',$data);
	}
}
