<?php

namespace Cliente;

use Signature\SignatureMonthly;

class Cliente
{
    private $promotionalCode;
    private $signature;

    public function __construct()
    {
        $this->signature = new SignatureMonthly();
        $this->promotionalCode = $this->signature->getCode();
    }
}