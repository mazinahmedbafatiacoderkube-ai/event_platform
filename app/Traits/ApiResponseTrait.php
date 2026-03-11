<?php

namespace App\Traits;

trait ApiResponseTrait
{

public function success($data)
{
return response()->json([
'status'=>true,
'data'=>$data
]);
}

public function error($message)
{
return response()->json([
'status'=>false,
'message'=>$message
],400);
}

}