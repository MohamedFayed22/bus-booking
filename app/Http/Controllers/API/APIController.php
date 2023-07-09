<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class APIController extends Controller
{
    /**
     * Send API Response in JSON format.
     *
     * @param mixed $result
     * @param string $message
     * @return JsonResponse
     */
    public function sendResponse(mixed $result, string $message = 'Request Complete'): JsonResponse
    {
        return Response::json([
            'success' => true,
            'data' => $result,
            'message' => $message
        ], 200);
    }

    /**
     * Send Error API Response in JSON format.
     *
     * @param string $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $error = 'Error!', int $code = 404): JsonResponse
    {
        return Response::json(self::makeError($error), $code);
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError(string $message, array $data = []): array
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }


    /**
     * Send Successful API Response in JSON format.
     *
     * @param string $message
     * @return JsonResponse
     */
    public function sendSuccess(string $message = 'OK'): JsonResponse
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
