<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 
{
    public function updateUser()
    {
        $this->db->update('user');
    }

    public function changePassword($email, $password_hash)
    {
        $this->db->set('password', $password_hash);
        $this->db->where('email', $email);
        $this->db->update('user');
    }
}
