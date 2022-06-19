<?php

namespace Cms\shop\shippingAndPayment;

use Cms\shop\shippingAndPayment\CreditCard;

class CreditCardFactory {

    public function getCardIssuer($issuerName) {
        switch ($issuerName) {
            case 'mastercard':
                return $this->mastercard();
            case 'visa':
                return $this->visa();
        }
    }

    private function mastercard() {

        $mastercardRegex = '/^5[1-5][0-9]{14}$/';

        $creditCard = new CreditCard();
        $creditCard->setCardNumberPattern($mastercardRegex);
        return $creditCard;
    }

    private function visa() {

        //4 at the beggining, old visa cards = 13 digits, new visa cards = 16 digits
        $visaRegex = '/^4([0-9]{12})(?:[0-9]{3})?$/';

        $creditCard = new CreditCard();
        $creditCard->setCardNumberPattern($visaRegex);
        return $creditCard;
    }
}