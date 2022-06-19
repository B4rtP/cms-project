<?php

use Cms\core\Controller;
use Cms\core\helpers\SessionHelper;
use Cms\models\User;
use Cms\shop\models\Product;
use Cms\shop\models\Order;
use Cms\shop\models\ShippingProvider;
use Cms\shop\shippingAndPayment\ShippingCalculator;

class SummaryController extends Controller {

    public function indexAction() {

        $shippingProviderId = $_SESSION['shipping-provider'];
        $payMethod = $_SESSION['payment-method'];
        $totalWeight = $_SESSION['total-weight'];
        $subtotal = $_SESSION['subtotal'];
        $productsInCart = $_SESSION['cart'];

        $product = new Product($this->dbc);
        $shippingProvider = new ShippingProvider($this->dbc);
        $shippingCalculator = new ShippingCalculator();

        $productIds = SessionHelper::getUniqueValues('cart');
        $quantity = SessionHelper::countUniqueValues('cart');
        $shippingProviderInstance = $shippingProvider->findBy('id', $shippingProviderId);

        $shippingPrice = $shippingCalculator->calculateTotalShipping(
            $shippingProviderInstance->price_per_kilo, $totalWeight);

        $data['products'] = $product->findAllBy('id', $productIds);
        $data['quantity'] = $quantity;
        $data['shippingProvider'] = $shippingProviderInstance;
        $data['paymentMethod'] = $payMethod;
        $data['totalWeight'] = $totalWeight;
        $data['productCount'] = count($productsInCart);
        $data['subtotal'] = $subtotal;
        $data['shippingPrice'] = $shippingPrice;
        $data['total'] = $_SESSION['total'] = $subtotal + $shippingPrice;

        $data['customerInfo'] = $customerInfo = $this->getUserInfo();

        if ($_POST['submit-order'] ?? false) {
            $this->orderHandler($customerInfo);
            return;
        }

        $this->view->display('shop-summary', $data);

    }

    private function getUserInfo() {
        if($_SESSION['user'] ?? false) {

            $username = $_SESSION['user'];
            $user = new User($this->dbc);
            return $user->findBy('username', $username);
        }
        return $_SESSION['guest-customer'];
    }

    private function orderHandler() {

        if($_SESSION['user'] ?? false) {
            $user = new User($this->dbc);
            $userObj = $user->findBy('username', $_SESSION['user']);
        }

        $arrayToSave = [
            'shipping_provider_id' => $_SESSION['shipping-provider'],
            'payment_method' => $_SESSION['payment-method'],
            'total_price' => $_SESSION['total'],
            'fname' => $_SESSION['guest-customer']['fname'] ?? $userObj->fname,
            'lname' => $_SESSION['guest-customer']['lname'] ?? $userObj->lname,
            'email' => $_SESSION['guest-customer']['email'] ?? $userObj->email,
            'phone' => $_SESSION['guest-customer']['phone'] ?? $userObj->phone,
            'address' => $_SESSION['guest-customer']['address'] ?? $userObj->address,
            'postal_code' => $_SESSION['guest-customer']['pcode'] ?? $userObj->postal_code,
            'country' => $_SESSION['guest-customer']['country'] ?? $userObj->country,
        ];

        if($_SESSION['cc-info'] ?? false) {
            $arrayToSave += [
                'cardholder' => $_SESSION['cc-info']['cardholder'],
                'card_number' => $_SESSION['cc-info']['card-number'],
                'expiration' => $_SESSION['cc-info']['expiration'],
                'cvv' => $_SESSION['cc-info']['cvv']
            ];
        }

        $cartIdAndCount = SessionHelper::countUniqueValues('cart');
        $productIdAndCountJson = json_encode($cartIdAndCount);
        $arrayToSave['products'] = $productIdAndCountJson;

        $order = new Order($this->dbc);
        $order->save($arrayToSave);
        SessionHelper::unsetByKeysIfExist([
            'cart',
            'subtotal',
            'total',
            'total-weight',
            'shipping-provider',
            'payment-method',
            'guest-customer',
            'cc-info']);
        
        header('Location:/shop/order_successfully_sent');
        exit;
    }

    public function orderCompletedAction() {
        $this->view->display('shop-order-completed');
    }

}