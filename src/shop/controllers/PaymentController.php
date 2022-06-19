<?php

use Cms\core\Controller;
use Cms\core\Validation;
use Cms\core\validationRules\OnlyLetters;
use Cms\core\validationRules\ValidateAgainstPattern;
use Cms\shop\shippingAndPayment\CreditCardFactory;

class PaymentController extends Controller {

    public function indexAction() {

        $cardIssuer = $_SESSION['payment-method'];

        $ccFactory = new CreditCardFactory();
        $cardInstance = $ccFactory->getCardIssuer($cardIssuer);

        if($_POST['submit-cc'] ?? false) {

            $cardholder = $_POST['cc-name'];
            $cardNumber = $_POST['cc-number'];
            $expiration = $_POST['cc-expiration'];
            $cvv = $_POST['cc-cvv'];

            $validator = new Validation();
            $validator
            ->validate($cardholder, 'cc-holder', [new OnlyLetters])

            ->validate($cardNumber, 'cc-number', [
                new ValidateAgainstPattern($cardInstance->getCardNumberPattern())])

            ->validate($expiration, 'cc-expiration', [
                new ValidateAgainstPattern($cardInstance->getExpirationPattern())
            ])

            ->validate($cvv, 'cc-cvv', [
                new ValidateAgainstPattern($cardInstance->getCvvPattern())
            ]);

            if(!$data['errors'] = $validator->getErrors()) {

                $_SESSION['cc-info'] = [
                    'cardholder' => $cardholder,
                    'card-number' => $cardNumber,
                    'expiration' => $expiration,
                    'cvv' => $cvv ];

                header('Location:/shop/summary');
                exit;
            }
        }

        $this->view->display('shop-card-payment', $data ?? []);
    }
}