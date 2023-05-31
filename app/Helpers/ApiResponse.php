<?php

namespace App\Helpers;

class ApiResponse
{
    public $success;
    public $message;
    public $data;

    public function __construct($error, $message, $data = null)
    {
        $this->error = $error;
        $this->message = $message;
        $this->data = $data;
    }

    public function toJson()
    {
        return response()->json([
            'error' => $this->error,
            'message' => $this->message,
            'data' => $this->data,
        ]);
    }
}
