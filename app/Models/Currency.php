<?php

namespace App\Models;

class Currency
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = strtoupper($code);
    }

    public function equals(Currency $other): bool
    {
        return $this->code === $other->code;
    }
}
