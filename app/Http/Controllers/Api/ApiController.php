<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

abstract class ApiController extends Controller
{
    private int $statusCode = 200;
    private array $body = [];
    private string $message = '';
    private array $errors = [];

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    public function setBody(array $body)
    {
        $this->body = $body;
        return $this;
    }
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }
    public function sendResponse()
    {
        return response()->json(array_merge((!empty($this->errors) ?$this->errors : $this->body),[
            'message' => $this->message,
        ]), $this->statusCode, []);
    }
}
