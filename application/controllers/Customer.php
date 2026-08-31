<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getauthcrm') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
		$this->load->model('usermodel');
        $this->load->model('customer_model','customermodel');

		$this->load->library('pagination');
    }
	public function index()
	{
		$config['base_url'] = base_url().'customer/index'; // The URL to your controller method
        $config['total_rows'] = $this->customermodel->countdata(); // Total records in your table
        $config['per_page'] = $this->session->userdata('perpage-customer')=='' ? 15 : $this->session->userdata('perpage-customer'); // Records per page
        $config['uri_segment'] = 3; // Which URL segment contains the page number
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$header['header'] = [
			'menu' => 'master'
		];
		$data = [
			'data' => $this->customermodel->getdata($config['per_page'],$page)
		];
		$footer['footer'] = [
			'menu' => 'customer'
		];

		$data['jumlahrek'] = $this->customermodel->countdata();
        $data['links'] = $this->pagination->create_links();

		$this->load->view('layouts/header',$header);
		$this->load->view('customer/customer',$data);
		$this->load->view('layouts/footer',$footer);
	}
	public function clear(){
		$this->session->unset_userdata('select-tipe');
		$url = base_url().'customer';
		redirect($url);
	}
	public function addsession(){
		$kode = isset($_POST['tipe']) ? $_POST['tipe'] : '';
		$page = isset($_POST['page']) ? $_POST['page'] : '';
		$cari = isset($_POST['text']) ? $_POST['text'] : '';
		if($kode==''){
			$this->session->unset_userdata('select-tipe');
		}else{
			$this->session->set_userdata('select-tipe',$kode);
		}
		if($page==''){
			$this->session->unset_userdata('perpage-customer');
		}else{
			$this->session->set_userdata('perpage-customer',$page);
		}
		if($cari==''){
			$this->session->unset_userdata('cari-customer');
		}else{
			$this->session->set_userdata('cari-customer',$cari);
		}
		echo 1;
	}
	public function addcustomer(){
		$data = [
			'getnegara' => $this->customermodel->getnegara()
		];
		$this->load->view('customer/addcustomer',$data);
	}
	public function simpancustomer(){
		$data = [
            'kode_customer' => strtoupper($_POST['kode_customer']),
            'nama_customer' => strtoupper($_POST['nama_customer']),
            'buyer' => strtoupper($_POST['buyer']),
            'exdo' => $_POST['exdo'],
            'port' => $_POST['port'],
            'country' => $_POST['country'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'kab_kota' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'keterangan' => $_POST['keterangan'],
            'buycode' => $_POST['buycode'],
            'inscode' => $_POST['inscode'],
            'jcode1' => $_POST['jcode1'],
            'jcode2' => $_POST['jcode2'],
            'benua' => $_POST['benua'],
            'region' => $_POST['region'],
            'kode_negara' => $_POST['kode_negara'],
            'pembeli' => $this->input->post('pembeli') ? 1 : 0,
            'cust_id' => $_POST['cust_id'],
            'jns_pkp' => $_POST['jns_pkp'],
            'nik' => $_POST['nik']
		];
		$qry = $this->customermodel->simpancustomer($data);
		echo $qry;
	}
	public function updatecustomer(){
		$data = [
            'id' => $_POST['id'],
            'kode_customer' => strtoupper($_POST['kode_customer']),
            'nama_customer' => strtoupper($_POST['nama_customer']),
            'buyer' => strtoupper($_POST['buyer']),
            'exdo' => $_POST['exdo'],
            'port' => $_POST['port'],
            'country' => $_POST['country'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'kab_kota' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'keterangan' => $_POST['keterangan'],
            'buycode' => $_POST['buycode'],
            'inscode' => $_POST['inscode'],
            'jcode1' => $_POST['jcode1'],
            'jcode2' => $_POST['jcode2'],
            'benua' => $_POST['benua'],
            'region' => $_POST['region'],
            'kode_negara' => $_POST['kode_negara'],
            'pembeli' => $this->input->post('pembeli') ? 1 : 0,
            'cust_id' => $_POST['cust_id'],
            'jns_pkp' => $_POST['jns_pkp'],
            'nik' => $_POST['nik']
		];
		$qry = $this->customermodel->updatecustomer($data);
		echo $qry;
	}
	public function hapusdata($id){
		$hasil = $this->customermodel->hapusdata($id);
		if($hasil){
			$url = base_url().'customer';
			redirect($url);
		}
	}
	public function editdata($id){
		$data = [
			'getnegara' => $this->customermodel->getnegara(),
			'data' => $this->customermodel->getcustomerbyid($id)
		];
		$this->load->view('customer/editcustomer',$data);
	}
}
