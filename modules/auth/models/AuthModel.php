<?php

class AuthModel extends CI_Model
{

    const SESSION_KEY = 'user_id';
    const TABLE_NAME = 'users';

    public function login($username, $password)
    {

        $user = $this->db->where('email', $username)->get(self::TABLE_NAME)->row();

        if (!$user) {
            return FALSE;
        }

        if (!password_verify($password, $user->password)) {
            return FALSE;
        }

        $this->session->set_userdata([self::SESSION_KEY => $user->id]);

        return $this->session->has_userdata(self::SESSION_KEY);
    }

    public function logout()
    {
        $this->session->unset_userdata(self::SESSION_KEY);
        return !$this->session->has_userdata(self::SESSION_KEY);
    }
}
