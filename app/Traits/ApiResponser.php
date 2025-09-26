<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponser
{
    protected function success($data, string $message = null)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function error(string $message = null, $data = null, $status_code)
    {

        throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => $message,
                'data' => $data
            ], $status_code));
    }
}