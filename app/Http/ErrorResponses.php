<?php

namespace App\Http;

trait ErrorResponses
{
    /**
     * Error validation response
     *
     * @param string $message
     * @param null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseErrorValidation($message = '', $errors = null)
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors
        ], StatusCodes::UNPROCESSABLE_ENTITY);
    }

    /**
     * Error response not found
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseErrorNotFound($message = '')
    {
        return $this->responseError($message, StatusCodes::NOT_FOUND);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($message = '', $status = StatusCodes::NOT_FOUND)
    {
        return response()->json([
            'message' => $message,
            'errors' => null
        ], $status);
    }
}