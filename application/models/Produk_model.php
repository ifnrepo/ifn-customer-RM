<?php
class produk_model extends CI_Model
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
    public function editjala($data){
        // Cek kode terlebih dahulu 
        $this->db->where('trim(kode)',trim($data['kode']));
        $ada = $this->db->get('tb_produk');
        if($ada->num_rows() > 0){
            $idx = $data['id'];
            unset($data['id']);
            $this->db->where('id',$idx);
            $this->db->update('tb_produk',$data);
            $hasil = 0;
        }else{
            unset($data['id']);
            $hasil = $this->db->insert('tb_produk',$data);
        }
        return $hasil;
    }
    public function simpanother($data){
        return $this->db->insert('tb_produk',$data);
    }
    public function getdata($limit=0,$start=0){
        $kode = $this->session->userdata('select-tipe');
        $this->db->select('tb_produk.*,kategori.nama_kategori');
        $this->db->join('kategori','kategori.kategori_id = tb_produk.kategori_id','left');
        if($kode!=''){
            $this->db->where('tb_produk.kategori_id',$kode);
        }
        $this->db->order_by('tb_produk.id');
        $this->db->limit($limit,$start);
        return $this->db->get('tb_produk');
    }
    public function countdata(){
        $kode = $this->session->userdata('select-tipe');
        $this->db->select('tb_produk.*,kategori.nama_kategori');
        $this->db->join('kategori','kategori.kategori_id = tb_produk.kategori_id','left');
        if($kode!=''){
            $this->db->where('tb_produk.kategori_id',$kode);
        }
        return $this->db->get('tb_produk')->num_rows();
    }
    public function getprodukbyid($id){
        $this->db->select('tb_produk.*,kategori.nama_kategori,kategori.kode_oth,kategori.net');
        $this->db->join('kategori','kategori.kategori_id = tb_produk.kategori_id','left');
        $this->db->where('tb_produk.id',$id);
        return $this->db->get('tb_produk')->row_array();
    }
    public function hapusdata($id){
        $this->db->where('id',$id);
        return $this->db->delete('tb_produk');
    }
}