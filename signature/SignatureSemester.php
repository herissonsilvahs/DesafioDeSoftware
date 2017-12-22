<?php

namespace Signature;

class SignatureSemester extends Signature
{
    public function __construct($discount = null)
    {
        if ($discount!=null)
            $this->discount = $discount;

        $this->freeTrialDays = 5;
        $this->renewDiscount = 10;
    }

    public function pay()
    {
        $this->expirateDays += 180;
        $this->active = true;
        $this->sendEmailPaymment();
        $this->sendEmailPromotionalCode();
    }

    protected function sendEmailPromotionalCode()
    {
        $this->generateCode();
        $email_body = "Voce possue ".$this->renewDiscount." na renovacao para assinatura anual".
        "Codigo promocional: ". $this->client_code;
    }

    protected function sendExpirateSignature()
    {
        $email_body = "Faltam apenas ". $this->expirateDays ." para expirar sua assinatura<br/>".
        "Renovar assinatura<br/>Assinatura Anual com ".$this->renewDiscount."de desconto<br\>Assinatura mensal";
    }

    public function getCode()
    {
        return $this->client_code;
    }

    protected function generateCode()
    {
        $this->client_code = substr(uniqid(rand()), 0, 6);
    }

    protected function renewSignature($renew = true, $signature = null)
    {
        if ($renew && $signature == null)
            return new SignatureMonthly();
        elseif ($renew && $signature == "semestral")
            return new SignatureSemester();
        elseif ($renew && $signature == "anual")
            return new SignatureYearly($this->renewDiscount);
    }
}