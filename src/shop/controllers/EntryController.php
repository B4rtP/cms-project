<?php

use Cms\core\Authentication;
use Cms\core\Controller;
use Cms\core\Validation;
use Cms\core\validationRules\ValidateEmail;
use Cms\core\validationRules\ValidateNoEmpty;
use Cms\core\validationRules\ValidateMinLenght;
use Cms\core\validationRules\ValidateMinNumberLenght;
use Cms\core\validationRules\ValidateMinSpecialCharLenght;
use Cms\core\validationRules\ValidateMinUpperLenght;
use Cms\core\validationRules\ValidateStringMatch;
use Cms\models\User;
use Cms\core\traits\ReusableValidationTrait;
use Cms\core\validationRules\OnlyLettersAndNumbers;

class EntryController extends Controller {

    use ReusableValidationTrait;

    public function loginAction() {

        $this->redirectIfSessionSet('shop');

        if($_POST['login'] ?? 0) {

            $email = $_POST['email'];
            $passwd = $_POST['password'];

            $validator = new Validation();
            
            $validator
            ->validate($email, 'email', [new ValidateNoEmpty, new ValidateEmail])
            ->validate($passwd, 'password', [new ValidateNoEmpty]);
            
            if(!$data['errors'] = $validator->getErrors()) {
                
                $auth = new Authentication();
                if($user = $auth->verifyBy('email', $email, $passwd)) {

                    $_SESSION['user'] = $user->username;

                    $this->unsetSessionGuestInfo();
                    header('Location:/shop');
                    exit;
                    
                }
                $data['errors']['access'] = 'Email or password is invalid';
            }
        }
        $this->view->display('login', $data ?? []);
    }

    public function registerAction() {

        $this->redirectIfSessionSet('shop');

        if($_POST['register'] ?? 0) {

            $fName = $_POST['fname']; $lName = $_POST['lname'];
            $uName = $_POST['uname']; $email = $_POST['email'];
            $phone = $_POST['phone']; $address = $_POST['address'];
            $postCode = $_POST['post-code']; $country = $_POST['country'];
            $password = $_POST['passwd']; $password2 = $_POST['passwd-2'];

            $validator = new Validation();
            $auth = new Authentication();

            // trait
            $this->validateCommonFields($validator, $fName, $lName, $email,
            $phone, $address, $postCode, $country);

            $validator
            ->validate($uName, 'uname', [new ValidateNoEmpty, new OnlyLettersAndNumbers])
            ->validate($password, 'passwd', [
                new ValidateNoEmpty,
                new ValidateMinNumberLenght(1),
                new ValidateMinSpecialCharLenght(1),
                new ValidateMinUpperLenght(1),
                new ValidateMinLenght(8)])

            ->validate($password2, 'passwd2', [new ValidateStringMatch($password)]);

            $data['errors'] = $validator->getErrors();

            $auth->recordExists('username', $uName) ?
            $data['errors']['uname'] = 'username is already taken' : null;
            
            $auth->recordExists('email', $email) ?
            $data['errors']['email'] = 'email is already registered' : null;
            

            if(!$data['errors']) {

                $passwdHash = password_hash($password, PASSWORD_DEFAULT);

                $user = new User($this->dbc);
                $user->save([
                    'fname' => $fName, 'lname' => $lName,
                    'username' => $uName, 'email' => $email,
                    'phone' => $phone, 'address' => $address,
                    'postal_code' => $postCode, 'country' => $country,
                    'password' => $passwdHash, 'privileges' => 'user'

                ]);

                $this->unsetSessionGuestInfo();
                
                $_SESSION['user'] = $uName;
                header('Location:/shop');
                exit;
            }
        }

        $this->view->display('register', $data ?? []);
    }

    public function logoutAction() {

        unset($_SESSION['user']);
        header('Location:/shop');
        exit;
    }

    private function redirectIfSessionSet($location) {
        if($_SESSION['user'] ?? false) {
            header('Location:/'.$location);
            exit;
        }
    }

    private function unsetSessionGuestInfo() {
        if($_SESSION['guest-customer'] ?? false) {
            unset($_SESSION['guest-customer']);
        }
    }
}