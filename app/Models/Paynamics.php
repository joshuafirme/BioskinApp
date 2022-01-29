<?php

namespace App\Models;

use nusoap_client;

use Illuminate\Database\Eloquent\Model;

class Paynamics extends Model
{
    public function getPaymentStatus($request_id, $response_id) {
        $mode = 'Test';

        if ($mode == 'Test') {
            $mid = "000000201221F7E57B0B";
            $mkey = "35440C9612BDA6F568EAA9A5BA7A6BEA";
            $client = new nusoap_client('https://testpti.payserv.net/Paygate/ccservice.asmx?WSDL', 'wsdl');
        } elseif ($mode == 'Live') {
            $mid = $this->_paymentMethod->getMerchantConfig('live_mid');
            $mkey = $this->_paymentMethod->getMerchantConfig('live_mkey');
            $client = new nusoap_client('https://testpti.payserv.net/Paygate/ccservice.asmx?WSDL', 'wsdl');
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
