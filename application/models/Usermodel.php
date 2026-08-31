<?php
class Usermodel extends CI_Model
{
    public function getdatabyid($id){
        $this->db->where('id',$id);
        return $this->db->get('user');
    }
    public function getdatabyuser($nama){
        $this->db->where('username',$nama);
        return $this->db->get('user');
    }
}