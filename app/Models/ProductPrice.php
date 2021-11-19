<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $table = 'product_price';
    public function readPricePerVolume($sku)
    {
        return $this->where('sku', $sku)->get();
    }

    public function removePricePerVolume($sku, $volume) {
        $this->where('sku', $sku)
            ->where('volume', $volume)->delete();

            return response()->json([
                'status' =>  'success',
                'message' => 'Data was deleted.'
            ], 200);
    }

    public function readVolumes($sku) {
        $volumes = $this->where('sku',$sku)->get('volume');
        $volume = "";
        if ($volumes) {
            $counter = count($volumes)-1;
            foreach($volumes as $key => $data) {
                $delimiter = $counter == $key ? '' : ',';
                $volume .= $data->volume . $delimiter;
            }
        }
        return $volume;
    }
}
