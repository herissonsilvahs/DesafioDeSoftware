<?php

namespace Signature;

abstract class Signature
{
    private $price;
    private $is_active;
    private $trialDays;
    private $currentDay;
    private $discount;

    public abstract function pay();

    public abstract function renew($signature);

    public abstract function getCode();

    public function cancel()
    {
        if ($this->trialDays > 0)
            echo "Valor a pagar R$ 0";
        elseif ($this->discount > 0)
        {
            $valor = $this->price - ($this->price * ($this->discount / 100));
            echo "Valor a pagar " . $valor;
        }else
            echo "Valor a pagar " . $this->price;
    }

    protected function signatureExpiration()
    {
        if($this->currentDay == 15)
        {
            echo "Envia aviso de expiração";
        }
    }

    protected function generateCode($lenght)
    {
        return substr(uniqid(rand()), 0, $lenght);
    }
}