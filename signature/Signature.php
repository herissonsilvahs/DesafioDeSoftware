<?php

namespace Signature;

abstract class Signature
{
    protected $freeTrialDays;
    protected $active;
    protected $price;
    protected $discount;
    protected $renewDiscount;
    protected $expirateDays;
    public $client_code;

    public abstract function pay();

    protected function sendEmailPaymment()
    {
        $email_body = "Pagamento efetuado, sua assinatura está ativa";
    }

    protected abstract function sendEmailPromotionalCode();

    protected abstract function sendExpirateSignature();

    public function cancel()
    {
        if ($this->freeTrialDays > 0)
            return 0.0;

        if (isset($this->discount) and $this->discount > 0)
            return $this->price * ($this->discount / 100);

        return $this->price;
    }

    public abstract function getCode();

    protected abstract function generateCode();

    protected abstract function renewSignature($renew = true, $signature = null);

}