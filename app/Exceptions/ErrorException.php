<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Repositories\ErrorMessagesRepository;
use Symfony\Component\HttpFoundation\Response;

class ErrorException extends Exception {

    private   $slug;
    private   $error;
    protected $message;
    private   $defaults = ['slug' => 'error', 'error' => '', 'message' => null];
    private   $data     = [];
    public function __construct(array $exception = []) {
        $this->data = $exception;
        $this->getException();
        $this->setMessage();
        parent::__construct($this->message, 200, null);
    }

    public function render(Request $request) {
        return response()->json([
            'slug'    => $this->getSlug(),
            'message' => $this->getMessage(),
            'error'   => $this->getError(),
            'line'    => $this->getLine(),
            'file'    => $this->getFile(),
            'status'  => false
        ], 200); //Para excepciones controlados
    }

    public function getException() {
        [
            'slug'    => $this->slug,
            'error'   => $this->error,
            'message' => $this->message
        ] = array_merge($this->defaults, $this->data);
    }

    public function setMessage() {

        if (is_null($this->message)) {
            $this->message = $message ?? ErrorMessagesRepository::getMessage($this->slug);
        }
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getError() {
        return $this->error;
    }

    public function getResponse() {
        return (object)[
            'message' => $this->getMessage(),
            'slug'    => $this->getSlug(),
            'error'   => $this->getError(),
            // 'code'    => $this->getCode(),
            'line'    => $this->getLine(),
            'file'    => $this->getFile(),
            'status'  => false
        ];
    }
}
