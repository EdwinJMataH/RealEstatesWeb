<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Repositories\ErrorMessagesRepository;
use Symfony\Component\HttpFoundation\Response;

class ErrorException extends Exception {

    private $slug;
    private $error;
    public function __construct(string $slug = null, string $error = null) {
        $this->slug  = $slug ?? 'error';
        $this->error = $error ?? '';
        parent::__construct(ErrorMessagesRepository::getMessage($slug), 200, null);
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
            'code'    => $this->getCode(),
            'line'    => $this->getLine(),
            'file'    => $this->getFile(),
            'status'  => false
        ];
    }
}
