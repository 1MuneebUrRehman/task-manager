<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class BaseController
 *
 * This class serves as the base controller for handling response formatting in the application.
 * It provides methods for sending success and error responses in JSON format.
 *
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    /**
     * Send success response method.
     *
     * @param  mixed  $result  The data to be included in the response.
     * @param  string  $message  A message describing the success.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success with data and message.
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Send error response method.
     *
     * @param  string  $error  A description of the error that occurred.
     * @param  array  $errorMessages  An optional array of error messages.
     * @param  int  $code  The HTTP status code to be returned (default: 404).
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating failure with error message and optionally error data.
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
