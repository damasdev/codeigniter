<?php

class Auth_library
{
    const SESSION_KEY = 'user';

    public function __construct()
    {
        $this->load->model('user/User_model', 'userModel');

        $this->load->driver(
            'cache',
            [
                'adapter' => 'apc',
                'backup' => 'file'
            ]
        );
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @param string $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    /**
     * login
     *
     * @param  string $email
     * @param  string $password
     * @return ?stdClass
     */
    public function login(string $email, string $password): ?stdClass
    {
        $user = $this->userModel->findWithRole([
            'users.email' => $email
        ]);

        if (!$user) {
            throw new Exception("Email is not registered yet");
        }

        if (!password_verify($password, $user->password)) {
            throw new Exception("Password did not match");
        }

        // Set
        $this->setData(
            self::SESSION_KEY,
            (object)[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        );

        return $this->user();
    }

    /**
     * logout
     *
     * @return bool
     */
    public function logout(): bool
    {
        $this->session->unset_userdata(self::SESSION_KEY);

        return !$this->session->has_userdata(self::SESSION_KEY);
    }

    /**
     * isLoggedIn
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return (bool) $this->session->has_userdata(self::SESSION_KEY);
    }

    /**
     * User
     *
     * @return ?stdClass
     */
    public function user(): ?stdClass
    {
        return $this->getData(self::SESSION_KEY);
    }

    /**
     * Get Data
     *
     * @param  string $key
     * @param  bool $cache
     * @return ?stdClass
     */
    private function getData(string $key, bool $cache = false)
    {
        if ($cache) {
            return $this->cache->get($key);
        } else {
            return $this->session->userdata($key);
        }
    }

    /**
     * Set Data
     *
     * @param  string $key
     * @param  stdClass $data
     * @param  bool $cache
     * @return void
     */
    private function setData(string $key, stdClass $data, bool $cache = false): void
    {
        if ($cache) {
            $this->cache->save($key, $data);
        } else {
            $this->session->set_userdata([
                $key => $data
            ]);
        }
    }
}
