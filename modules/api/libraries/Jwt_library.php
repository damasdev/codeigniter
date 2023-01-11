<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Jwt_library
{
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
     * Validate Token
     *
     * @return bool
     */
    public function validate(): bool
    {
        try {
            $token = $this->input->get_request_header('Authorization');
            if (!$token) {
                throw new Exception('Token Not Found');
            }

            $data = $this->decode(substr($token, 7));
            if (!$data) {
                throw new Exception("Invalid Token");
            }

            if ($data->exp < strtotime(date('Y-m-d'))) {
                throw new Exception("Token Expired");
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Encode JWT
     *
     * @param  array $payload
     * @return string
     */
    public function encode(array $payload): string
    {
        // token will expired in 1 day
        $payload['exp'] = strtotime(date('Y-m-d') . ' +1 days');

        return JWT::encode($payload, $this->input->server('JWT_SECRET_KEY'), 'HS256');
    }

    /**
     * Decode JWT
     *
     * @param  string $token
     * @return ?stdClass
     */
    public function decode(string $token): ?stdClass
    {
        try {
            return JWT::decode($token, new Key($this->input->server('JWT_SECRET_KEY'), 'HS256'));
        } catch (\Throwable $th) {
            return null;
        }
    }
}
