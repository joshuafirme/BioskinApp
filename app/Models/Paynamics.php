<?php

namespace App\Models;

use nusoap_client;

use Illuminate\Database\Eloquent\Model;

class Paynamics extends Model
{
    public function getPaymentStatus($request_id, $response_id) {

        $mode = env('PAYNAMICS_MODE');

        if ($mode == 'Test') {
            $mid = env('PAYNAMICS_TEST_MID');
            $mkey = env('PAYNAMICS_TEST_MKEY');
            $client = new nusoap_client('https://testpti.payserv.net/Paygate/ccservice.asmx?WSDL', 'wsdl');
        } elseif ($mode == 'Live') {
            $mid = env('PAYNAMICS_PROD_MID');
            $mkey = env('PAYNAMICS_PROD_MKEY');
            $client = new nusoap_client('https://ptipaygate.paynamics.net/ccservice/ccservice.asmx?WSDL', 'wsdl');
        }

        $request_id = '';
        $length = 8;
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $request_id .= $characters[rand(0, $charactersLength - 1)];
        }

        $merchantid = $mid;
        $requestid = $request_id;
        $org_trxid = $response_id;
        $org_trxid2 = "";
        $cert = $mkey;
        $data = $merchantid . $requestid . $org_trxid . $org_trxid2;
        $data = utf8_encode($data . $cert);

        // create signature
        $sign = hash("sha512", $data);

        $params = array(
            "merchantid" => $merchantid,
            "request_id" => $requestid,
            "org_trxid" => $org_trxid,
            "org_trxid2" => $org_trxid2,
            "signature" => $sign
        );

        $result = $client->call("query", $params);
        return $result;
    }
}
