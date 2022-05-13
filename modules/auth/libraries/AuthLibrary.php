<?php

class AuthLibrary
{
    const SESSION_KEY = 'user';
    const FEATURE_KEY = 'features';

    public function __construct()
    {
        $this->load->model('auth/AuthModel', 'authModel');
        $this->load->model('feature/FeatureModel', 'featureModel');

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
        try {
            $user = $this->authModel->login($email, $password);

            // Set
            $this->setData(
                self::SESSION_KEY,
                (object)[
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                    'role' => $user->role,
                    'type' => $user->type,
                ]
            );

            return $this->user();
        } catch (\Throwable $th) {
            //throw $th;
            return NULL;
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
     * @return ?stdClass
     */
    public function user(): ?stdClass
    {
        return $this->getData(self::SESSION_KEY);
    }

    /**
     * Features
     *
     * @param  int $roleId
     * @return array
     */
    public function features(int $roleId): array
    {
        $features = $this->getData(self::FEATURE_KEY, true);
        if (empty($features)) {

            $features = $this->featureModel->role($roleId);
            $this->setData(self::FEATURE_KEY, $features, true);
        }

        return $features;
    }

    public function getData($key, $cache = false)
    {
        if ($cache) {
            return $this->cache->get($key);
        } else {
            return $this->session->userdata($key);
        }
    }

    private function setData($key, $data, $cache = false): void
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
