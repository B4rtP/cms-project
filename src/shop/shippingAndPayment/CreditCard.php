<?php

namespace Cms\shop\shippingAndPayment;

class CreditCard {

    public $cardNumberPattern;

    private $expirationPattern = '/^(0[1-9]|1[0-2])\/([0-9]{4}|[0-9]{2})$/';
    private $cvvPattern = '/^[0-9][0-9][0-9]$/';

    public function setCardNumberPattern($pattern) {
        $this->cardNumberPattern = $pattern;
    }

    public function getCardNumberPattern() {
        return $this->cardNumberPattern;
    }

    public function getExpirationPattern() {
        return $this->expirationPattern;
    }

    public function getCvvPattern() {
        return $this->cvvPattern;
    }
}
