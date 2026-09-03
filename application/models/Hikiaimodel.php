<?php
class Hikiaimodel extends CI_Model
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
    public function simpanhikiai($data){
        return $this->db->insert('tb_hikiai',$data);
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
        $kode = $this->session->unset_userdata('kode-hikiai');
        $this->db->select('tb_hikiai.*,customer.nama_customer');
        $this->db->join('customer','customer.id = tb_hikiai.id_customer','left');
        if($this->session->has_userdata('cari-hikiai') && $this->session->userdata('cari-hikiai')!=''){
            $isi = $this->session->userdata('cari-hikiai');
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

            $this->db->like('nomor',$kata,'both', FALSE);
        }
        if($kode!=''){
            $this->db->where('tb_hikiai.exdo',$kode);
        }
        $this->db->where('month(tgl_hikiai)',$this->session->userdata('bulan-hik'));
        $this->db->where('year(tgl_hikiai)',$this->session->userdata('tahun-hik'));
        $this->db->order_by('tb_hikiai.id');
        $this->db->limit($limit,$start);
        return $this->db->get('tb_hikiai');
    }
    public function countdata(){
        $kode = $this->session->unset_userdata('kode-hikiai');
        $this->db->select('tb_hikiai.*,customer.nama_customer');
        $this->db->join('customer','customer.id = tb_hikiai.id_customer','left');
        if($this->session->has_userdata('cari-hikiai') && $this->session->userdata('cari-hikiai')!=''){
            $isi = $this->session->userdata('cari-hikiai');
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

            $this->db->like('nomor',$kata,'both', FALSE);
        }
        if($kode!=''){
            $this->db->where('tb_hikiai.exdo',$kode);
        }
        $this->db->where('month(tgl_hikiai)',$this->session->userdata('bulan-hik'));
        $this->db->where('year(tgl_hikiai)',$this->session->userdata('tahun-hik'));
        return $this->db->get('tb_hikiai')->num_rows();
    }
    public function getdatabyid($id){
        $this->db->select('tb_hikiai.*,customer.id as idcustomer,customer.nama_customer,customer.alamat');
        $this->db->join('customer','customer.id = tb_hikiai.id_customer','left');
        $this->db->where('tb_hikiai.id',$id);
        return $this->db->get('tb_hikiai')->row_array();
    }
    public function hapusdata($id){
        $this->db->where('id',$id);
        return $this->db->delete('tb_produk');
    }
    public function getdatacustomer($isi){
        $kata = '';
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

        $this->db->like('kode_customer',$kata,'both', FALSE);
        $this->db->or_like('buyer',$kata,'both', FALSE);
        return $this->db->get('customer');
    }
    public function getdataproduk($isi){
        $kata = '';
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
        $this->db->select('tb_produk.*,kategori.nama_kategori');
        $this->db->join('kategori','kategori.kategori_id = tb_produk.kategori_id','left');
        $this->db->like('tb_produk.kode',$kata,'both', FALSE);
        $this->db->or_like('tb_produk.spesifikasi',$kata,'both', FALSE);
        $this->db->limit(10);
        return $this->db->get('tb_produk');
    }
    public function simpandetailhikiai($data){
        for ($i=1; $i < 20; $i++) { 
            $cekitem = $this->db->get_where('tb_hikiai_detail',['id_hikiai' => $data['id_hikiai'],'item' => $i])->num_rows();
            if($cekitem==0){
                $data['item'] = (int) $i;
                $i=21;
            }
        }

        return $this->db->insert('tb_hikiai_detail',$data);
    }
    public function updatedetailhikiai($data){
        $id = $data['id'];
        unset($data['id']);
        $this->db->where('id',$id);
        return $this->db->update('tb_hikiai_detail',$data);
    }
    public function hapusdetailhikiai($id){
        $this->db->where('id',$id);
        return $this->db->delete('tb_hikiai_detail');
    }
    public function getdatadetail($id){
        $this->db->select('tb_hikiai_detail.*,tb_produk.spesifikasi,tb_produk.kode,satuan.kodesatuan');
        $this->db->join('tb_produk','tb_produk.id = tb_hikiai_detail.id_produk','left');
        $this->db->join('satuan','satuan.id = tb_hikiai_detail.id_satuan','left');
        $this->db->order_by('tb_hikiai_detail.item');
        return $this->db->get('tb_hikiai_detail');
    }
    public function getsatuan(){
        return $this->db->order_by('kodesatuan')->get('satuan');
    }
    public function simpandatahikiai($id){
        $this->db->select('sum(pcs) as pcs,sum(kgs) as kgs');
        $this->db->from('tb_hikiai_detail');
        $this->db->where('id_hikiai',$id);
        $jmlhik = $this->db->get()->row_array();

        $this->db->where('id',$id);
        return $this->db->update('tb_hikiai',['pcs' => $jmlhik['pcs'],'kgs' => $jmlhik['kgs'],'status_hikiai' => 1]);
    }
    public function editbatalhikiai($id){
        $this->db->where('id',$id);
        return $this->db->update('tb_hikiai',['pcs' => 0,'kgs' => 0,'status_hikiai' => 0]);
    }
    public function resetdetailhikiai($id){
        $this->db->where('id_hikiai',$id);
        return $this->db->delete('tb_hikiai_detail');
    }
    public function getdetailhikiaibyid($id){
        $this->db->select('tb_hikiai_detail.*,tb_produk.spesifikasi,kategori.nama_kategori');
        $this->db->from('tb_hikiai_detail');
        $this->db->join('tb_produk','tb_produk.id = tb_hikiai_detail.id_produk','left');
        $this->db->join('kategori','kategori.kategori_id = tb_produk.kategori_id','left');
        $this->db->where('tb_hikiai_detail.id',$id);
        return $this->db->get()->row_array();
    }
}