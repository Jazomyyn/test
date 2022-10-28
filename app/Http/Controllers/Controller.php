<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function completeResponse($success, $message ="", $data = null, $code = null ){
        $respCode = isset($code) ? $code : 200;
        return response()->json([
            'success' => $success,
            'message' =>$message,
            'data' => $data
        ],$respCode);
    }
}
