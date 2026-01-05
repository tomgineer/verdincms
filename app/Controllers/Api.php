<?php namespace App\Controllers;
use App\Libraries\VerdinApi;

class Api extends BaseController {

public function monitor() {
    $authHeader = $this->request->getHeaderLine('Authorization');
    $token = '';

    if (stripos($authHeader, 'Bearer ') === 0) {
        $token = trim(substr($authHeader, 7));
    }

    $expected = env('verdin.apiToken');

    if (!$expected) {
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'error' => 'missing_server_token',
        ]);
    }

    if (!$token || !hash_equals($expected, $token)) {
        return $this->response->setStatusCode(401)->setJSON([
            'success' => false,
            'error' => 'invalid_token',
        ]);
    }

    $api = new VerdinApi();
    $data = $api->getMonitoringData();

    return $this->response->setJSON([
        'success' => true,
        'data' => $data,
    ]);
}

} // End of Class
