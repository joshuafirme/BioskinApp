<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhilippineArea extends Model
{
    private $url = 'https://raw.githubusercontent.com/flores-jacob/philippine-regions-provinces-cities-municipalities-barangays/master/philippine_provinces_cities_municipalities_and_barangays_2019v2.json';

    public function URL()
    {
        return $this->url;
    }

    function curlRequest($url) {
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($c);
		curl_close($c);
		return $data;
	 }

    public function getProvinces($region){

        $json = $this->curlRequest($this->URL());
        $obj = $json === FALSE ? array() : json_decode($json, true);

        return $obj[$region]['province_list'];
    }

    public function getMunicipalities($region, $province){

        $json = $this->curlRequest($this->URL());
        $obj = $json === FALSE ? array() : json_decode($json, true);

        return $obj[$region]['province_list'][$province]['municipality_list'];
    }

    public function getBrgys($region, $province, $municipality){

        $json = $this->curlRequest($this->URL());
        $obj = $json === FALSE ? array() : json_decode($json, true);

        return $obj[$region]['province_list'][$province]['municipality_list'][$municipality]['barangay_list'];
    }

}
