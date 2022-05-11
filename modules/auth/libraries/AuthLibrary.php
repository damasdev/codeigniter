<?php

class AuthLibrary
{
    const SESSION_KEY = 'user';
    const FEATURE_KEY = 'features';

    public function __construct()
    {
        $this->load->model('auth/AuthModel', 'authModel');
        $this->load->model('feature/FeatureModel', 'featureModel');
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
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        try {
            $user = $this->authModel->login($email, $password);

            // Set
            $this->setData(
                self::SESSION_KEY,
                (object)[
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_root' => $user->is_root,
                    'role_id' => $user->role_id,
                ]
            );

            return $this->session->has_userdata(self::SESSION_KEY);
        } catch (\Throwable $th) {
            //throw $th;
            return FALSE;
        }
    }

    /**
     * logout
     *
     * @return bool
     */
    public function logout(): bool
    {
        $this->session->unset_userdata(self::SESSION_KEY);
        $this->session->unset_userdata(self::FEATURE_KEY);

        return !$this->session->has_userdata(self::SESSION_KEY);
    }

    /**
     * isLoggedIn
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return !!$this->session->has_userdata(self::SESSION_KEY);
    }

    /**
     * User
     *
     * @return stdClass
     */
    public function user(): stdClass
    {
        return $this->session->userdata(self::SESSION_KEY);
    }

    /**
     * Features
     *
     * @param  int $roleId
     * @return array
     */
    public function features(int $roleId): array
    {
        $features = $this->session->userdata(self::FEATURE_KEY);
        if (empty($features)) {

            $features = $this->featureModel->role($roleId);
            $this->setData(self::FEATURE_KEY, $features);
        }

        return $features;
    }

    private function setData($key, $data)
    {
        $this->session->set_userdata([
            $key => $data
        ]);
    }
}
