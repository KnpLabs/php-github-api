<?php
namespace ArgoCD\Exception;

class ValidationFailedException extends RuntimeException 
{
    private $errors = [];

    public function __construct($message = "", $code = 0, \Throwable $previous = null, array $errors = [])
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
