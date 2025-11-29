<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaravelApi extends CI_Controller {

    private $laravelBaseUrl; // ganti sesuai domain Laravel kamu
    private $ciSecretKey;

    public function __construct()
    {
        parent::__construct();
        $this->ciSecretKey = getenv('CI_SECRET_KEY') ?: 'default_value';
        $this->laravelBaseUrl = getenv('API_URL') ?: 'default_value';
        // atau kalau Laravel, bisa pakai env()
        // $this->ciSecretKey = env('CI_SECRET_KEY', 'default_value');
    }


    // ===========================================
    // 1. Function untuk REQUEST TOKEN dari Laravel
    // ===========================================
    private function getLaravelToken()
    {
        $postData = json_encode([
            'secret_key' => $this->ciSecretKey
        ]);

        // pre($this->ciSecretKey);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->laravelBaseUrl . "/api/request-token",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Accept: application/json"
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }


    // ===========================================
    // 2. Function GET DATA ke Laravel API (pakai token)
    // ===========================================
    public function getData()
    {
        // 1. Minta token baru
        $tokenResponse = $this->getLaravelToken();
        
        if (!$tokenResponse || !$tokenResponse['success']) {
            die("Gagal mendapatkan token dari Laravel");
        }

        $token = $tokenResponse['token'];


        // 2. Request data pakai Bearer Token
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->laravelBaseUrl . "/api/data-users",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $token,
                "Accept: application/json"
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
