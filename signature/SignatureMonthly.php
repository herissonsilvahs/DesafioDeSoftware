<?php

namespace Signature;


class SignatureMonthly extends Signature
{

    public function __construct()
    {
        $this->freeTrialDays = 5;
        $this->renewDiscount = 5;
    }

    public function pay()
    {
        $this->expirateDays += 30;
        $this->active = true;
        $this->sendEmailPaymment();
        $this->sendEmailPromotionalCode();
    }

    protected function sendEmailPromotionalCode()
    {
        $this->generateCode();
        $email_body = "Voce possue ".$this->renewDiscount." na renovacao para assinatura semestral".
        "Codigo promocional: ". $this->client_code;
    }

    protected function sendExpirateSignature()
    {
        $email_body = "Faltam apenas ". $this->expirateDays ." para expirar sua assinatura<br/>".
        "Renovar assinatura<br/>Assinatura Semestral com ".$this->renewDiscount."de desconto<br\>Assinatura anual";
    }

    public function getCode()
    {
        return $this->client_code;
    }

    protected function generateCode()
    {
        $this->client_code = substr(uniqid(rand()), 0, 5);
    }

    protected function renewSignature($renew = true, $signature = null)
    {
        if ($renew && $signature == null)
            return new SignatureMonthly();
        elseif ($renew && $signature == "semestral")
            return new SignatureSemester($this->renewDiscount);
        elseif ($renew && $signature == "anual")
            return new SignatureYearly();

    }
}