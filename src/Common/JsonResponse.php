<?php


namespace Zbanx\Kit\Common;

use Illuminate\Http\JsonResponse as Response;

trait JsonResponse
{
    public function json($message, $code, $data = null, $status_code = 200, $headers = []): Response
    {
        return response()->json([
            'code' => $code,
            'data' => $data,
            'message' => $message
        ], $status_code, $headers);
    }

    public function success($data = null, $message = "success"): Response
    {
        return $this->json($message, 0, $data);
    }

    public function error($message = "error", $code = -1, $data = null): Response
    {
        return $this->json($message, $code, $data);
    }
}
