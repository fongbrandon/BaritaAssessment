<?php

namespace App;
use App\Securities;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    public $timestamps = false;
    public static function getISINDescription($isin_code){
        $isin=$isin_code;
        
        $securities=Securities::where('isin_code',$isin)->first();
        return $securities->description;
    }
    public static function getStatusName($status){
        $statusId=$status;
        
        $status=StatusCodes::where('status_id',$statusId)->first();
        return $status->status_name;
    }
}
