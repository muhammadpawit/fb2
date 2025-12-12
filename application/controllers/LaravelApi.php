<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaravelApi extends CI_Controller {

    private $laravelBaseUrl; // ganti sesuai domain Laravel kamu
    private $ciSecretKey;

    public function __construct()
    {
        parent::__construct();
        $this->ciSecretKey = getenv('CI_SECRET_KEY') ?: $this->config->item('CI_SECRET_KEY');
        $this->laravelBaseUrl = getenv('API_URL') ?: $this->config->item('API_URL');
        
        // atau kalau Laravel, bisa pakai env()
        // $this->ciSecretKey = env('CI_SECRET_KEY', 'default_value');
        header('Access-Control-Allow-Origin: forboysproduction.com'); // bisa ganti * dengan domain front-end
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization, Content-Type');


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

    function index(){
        echo "Laravel API Controller";
        // echo $this->laravelBaseUrl;
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
    
    public function monitor()
    {
        // 1. Ambil token Laravel
        $tokenResponse = $this->getLaravelToken();
        if (!$tokenResponse || !$tokenResponse['success']) {
            echo json_encode([
                "draw" => intval($this->input->get('draw', 1)),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => "Gagal mendapatkan token dari Laravel API"
            ]);
            return;
        }

        $token = $tokenResponse['token'];

        // 2. Ambil filter & pagination dari FE
        $jenispo   = $this->input->get('jenispo')  ?: null;
        $validasi  = $this->input->get('validasi') ?: null;
        $model_po  = $this->input->get('model_po') ?: null;
        $page      = $this->input->get('page', 1);
        $per_page  = $this->input->get('per_page', 25);
        $draw      = intval($this->input->get('draw', 1));

        // 3. Build URL GET Query
        $params = http_build_query([
            "secret_key" => $this->ciSecretKey,
            "jenispo"    => $jenispo,
            "validasi"   => $validasi,
            "model_po"   => $model_po,
            "page"       => $page,
            "per_page"   => $per_page,
            "draw"       => $draw
        ]);

        $url = $this->laravelBaseUrl . "/api/monitor?" . $params;

        // 4. CURL GET
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$token}",
            "Accept: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo json_encode([
                "draw" => $draw,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => curl_error($ch)
            ]);
            curl_close($ch);
            return;
        }
        curl_close($ch);

        $result = json_decode($response, true);

        // 5. Kembalikan ke DataTables
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $result['recordsTotal'] ?? 0,
            "recordsFiltered" => $result['recordsFiltered'] ?? 0,
            "data" => $result['data'] ?? [],
            "message" => $result['message'] ?? null
        ]);
    }



}
