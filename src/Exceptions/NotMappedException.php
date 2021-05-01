<?php
namespace Dfossacecchi\HumbleMap\Exceptions;

class NotMappedException extends \UnexpectedValueException
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
