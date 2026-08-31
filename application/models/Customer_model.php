<?php
class customer_model extends CI_Model
{
    public function getkatproduk(){
        $notspek = ['1442','7734','0138','3429','0457','7822','6648','4380'];
        $this->db->where_not_in('kategori_id',$notspek);
        $this->db->where('jns < ',2);
        $this->db->order_by('nama_kategori');
        return $this->db->get('kategori');
    }
    public function netornot($xkode=0){
        $kode = $this->session->userdata('select-tipe');
        $data = $this->db->get_where('kategori',['kategori_id' => $kode]);
        if($data->num_rows() > 0){
            $xdata = $data->row_array();
            return $xkode==0 ? $xdata['net'] : $xdata['kode_oth'];
        }else{
            return 0;
        }
    }
    public function getjenisbenang(){
        return $this->db->get('ref_jnb');
    }
    public function getukuranbenang($jns){
        $this->db->where('jnb',$jns);
        $this->db->order_by('ukuran');
        return $this->db->get('tb_benang');
    }
    public function getcolor(){
        $this->db->where('aktif',1);
        $this->db->order_by('color');
        return $this->db->get('tb_color');
    }
    public function simpanjala($data){
        return $this->db->insert('tb_produk',$data);
    }
    public function updatecustomer($data){
        $id = $data['id'];
        unset($data['id']);
        $this->db->where('id',$id);
        return $this->db->update('customer',$data);
    }
    public function simpancustomer($data){
        return $this->db->insert('customer',$data);
    }
    public function getdata($limit=0,$start=0){
        $kode = $this->session->userdata('select-tipe');
        $this->db->select('customer.*,ref_negara.uraian_negara');
        $this->db->join('ref_negara','ref_negara.kode_negara = customer.kode_negara','left');
        if($this->session->has_userdata('cari-customer') && $this->session->userdata('cari-customer')!=''){
            $isi = $this->session->userdata('cari-customer');
            if(str_contains(trim($isi)," ")){
                $pisah = explode(" ",trim($isi));
                $hasil = '';
                foreach($pisah as $ps){
                    $hasil .= $ps.'%';
                }
                $kata = substr($hasil,0,strlen($hasil)-1);
            }else{
                $kata = trim($isi);
            }

            $this->db->group_start();
            $this->db->like('customer.buyer',$kata,'both', FALSE);
            $this->db->or_like('customer.alamat',$kata,'both', FALSE);
            $this->db->or_like('customer.port',$kata,'both', FALSE);
            $this->db->group_end();
        }
        if($kode!=''){
            $this->db->where('customer.exdo',$kode);
        }
        $this->db->order_by('customer.nama_customer');
        $this->db->limit($limit,$start);
        return $this->db->get('customer');
    }
    public function countdata(){
        $kode = $this->session->userdata('select-tipe');
        $this->db->select('customer.*,ref_negara.uraian_negara');
        $this->db->join('ref_negara','ref_negara.kode_negara = customer.kode_negara','left');
        if($this->session->has_userdata('cari-customer') && $this->session->userdata('cari-customer')!=''){
            $isi = $this->session->userdata('cari-customer');
            if(str_contains(trim($isi)," ")){
                $pisah = explode(" ",trim($isi));
                $hasil = '';
                foreach($pisah as $ps){
                    $hasil .= $ps.'%';
                }
                $kata = substr($hasil,0,strlen($hasil)-1);
            }else{
                $kata = trim($isi);
            }

            $this->db->group_start();
            $this->db->like('buyer',$kata,'both', FALSE);
            $this->db->or_like('alamat',$kata,'both', FALSE);
            $this->db->or_like('port',$kata,'both', FALSE);
            $this->db->group_end();
        }
        if($kode!=''){
            $this->db->where('customer.exdo',$kode);
        }
        return $this->db->get('customer')->num_rows();
    }
    public function getcustomerbyid($id){
        $this->db->select('customer.*');
        $this->db->join('ref_negara','ref_negara.kode_negara = customer.kode_negara','left');
        $this->db->where('customer.id',$id);
        return $this->db->get('customer')->row_array();
    }
    public function hapusdata($id){
        $this->db->where('id',$id);
        return $this->db->delete('customer');
    }
    public function getnegara(){
        $this->db->order_by('uraian_negara');
        return $this->db->get('ref_negara');
    }
}