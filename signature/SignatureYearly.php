<?php

namespace Signature;

class SignatureYearly extends Signature
{

    public function pay($discount = null)
    {
        if ($discount!=null)
            $this->discount = $discount;

        $this->freeTrialDays = 5;
        $this->renewDiscount = 20;
    }

    protected function sendEmailPromotionalCode()
    {
        $this->expirateDays += 365;
        $this->active = true;
        $this->sendEmailPaymment();
        $this->sendEmailPromotionalCode();
    }

    protected function sendExpirateSignature()
    {
        $this->generateCode();
        $email_body = "Voce possue ".$this->renewDiscount." na renovacao para assinatura anual".
            "Codigo promocional: ". $this->client_code;
    }

    public function getCode()
    {
        return $this->client_code;
    }

    protected function generateCode()
    {
        $this->client_code = substr(uniqid(rand()), 0, 7);
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