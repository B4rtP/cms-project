<?php

use Cms\core\Controller;
use Cms\core\helpers\SessionHelper;
use Cms\core\traits\ReusableValidationTrait;
use Cms\core\Validation;
use Cms\shop\models\Product;
use Cms\shop\models\ShippingProvider;
use Cms\shop\shippingAndPayment\ShippingCalculator;

class ShippingController extends Controller {

    use ReusableValidationTrait;

    public function shippingFormAction() {

        if ($_POST['submit-shipping-info'] ?? 0) {

            $fName = $_POST['fname'];
            $lName = $_POST['lname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $postCode = $_POST['pcode'];
            $country = $_POST['country'];

            $validator = new Validation();

            //trait
            $this->validateCommonFields($validator, $fName, $lName,
                $email, $phone, $address, $postCode, $country
            );

            if (!$data['errors'] = $validator->getErrors()) {

                $_SESSION['guest-customer'] = [
                    'fname' => $fName,
                    'lname' => $lName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'pcode' => $postCode,
                    'country' => $country];

                header('Location:/shop/shipping_method');
                exit;
            }
        }
        $this->view->display('shop-shipping-form', $data ?? []);
    }


    public function shippingMethodAction() {

        $provider = new ShippingProvider($this->dbc);

        $product = new Product($this->dbc);

        $productWeightAndCount = [];
        
        foreach (SessionHelper::countUniqueValues('cart') as $id => $count) {
            
            $productObj = $product->findBy('id', $id);
            $productWeightAndCount[$productObj->product_weight] = $count;  
        }
        $totalWeight = ShippingCalculator::calculateTotalWeight($productWeightAndCount);
        
        $data['providers'] = $provider->findAll();

        $data['totalWeight'] = $_SESSION['total-weight'] = $totalWeight;

        $data['payMethod'] = SessionHelper::containsValue('payment-method') ?
        $_SESSION['payment-method'] : '';

        if($_POST['submit-ship-method'] ?? 0) {

            $shippingProviderId = $_POST['provider'];
            $paymentMethod = $_POST['payment'];

            $_SESSION['shipping-provider'] = $shippingProviderId;
            $_SESSION['payment-method'] = $paymentMethod;

            if($paymentMethod == 'pay-on-delivery') {

                header('Location:/shop/summary');
                exit;
            }
            header('Location:/shop/credit_card');
            exit;
        }
        $this->view->display('shop-shipping-method', $data ?? []);
    }
}
