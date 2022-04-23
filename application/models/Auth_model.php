<?php
class Auth_model extends CI_Model
{
    public function tambahDataUser()
    {
        $email = $this->input->post('email', true);
        $data = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($email),
            'image' => 'default.jpg',
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 0,
            'date_created' => time()
        ];
        // siapkan token
        $token = $this->createToken($email);

        $this->db->insert('user', $data);
        return $token;
    }

    public function getUserByEmail($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function createToken($token_email)
    {
        $token = base64_encode(random_bytes(32));
        $user_token = [
            'email' => $token_email,
            'token' => $token,
            'date_created' => time()
        ];
        $this->db->insert('user_token', $user_token);
        return $token;
    }

    public function getToken($token)
    {
        return $this->db->get_where('user_token', ['token' => $token])->row_array();
    }
    public function updateIsActive($email)
    {
        $this->db->set('is_active', 1);
        $this->db->where('email', $email);
        $this->db->update('user');
        $this->db->delete('user_token', ['email' => $email]);
    }

    public function deleteUser($email)
    {
        $this->db->delete('user', ['email' => $email]);
        $this->db->delete('user_token', ['email' => $email]);
    }

    public function getEmail($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function updatePassword($password, $email)
    {
        $data = [
            'password' => $password,
        ];
        $this->db->where('email', $email);
        $this->db->update('user', $data);
    }
}
