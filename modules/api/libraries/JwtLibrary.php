<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtLibrary
{

    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Validate Token
     *
     * @return bool
     */
    public function validate(): bool
    {
        try {
            $token = $this->CI->input->get_request_header('Authorization');
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

            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
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

        return JWT::encode($payload, $this->CI->input->server('JWT_SECRET_KEY'), 'HS256');
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
            return JWT::decode($token, new Key($this->CI->input->server('JWT_SECRET_KEY'), 'HS256'));
        } catch (\Throwable $th) {
            return NULL;
        }
    }
}
