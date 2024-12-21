<?php
namespace app\controllers;
use app\model\ConnectionToDb;
use app\model\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;

class UserRegistrationController
{
    private $qb;
    private $templates;
    private $auth;
    public function __construct()
    {
        $this->qb = new QueryBuilder();
        $this->templates = new Engine('../app/views');
        $db = new ConnectionToDb();
        $this->auth = new Auth($db->getConnection());
    }

    public function registerView() {
        echo $this->templates->render('page_register');
    }
    public function loginView() {
        echo $this->templates->render('page_login');
    }

    public function login() {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
        header('Location: /php/Diplom_OOP/users');
    }

    public function logout() {
        $this->auth->logout();
        echo 'You have been logged out';
        header('Location: /php/Diplom_OOP/login');
    }

    public function registration()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], 'user',  function ($selector, $token)
            {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
//                    d($selector, $token);
                $this->auth->confirmEmail($selector, $token);
                header('Location: /php/Diplom_OOP/reg');
                exit;
            });
            echo 'We have signed up a new user with the ID ' . $userId;
            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
        header('Location: /php/Diplom_OOP/users');
    }

    public function verify() {
        try {
            $this->auth->confirmEmail('pS_MlSjM9SpE6hUS', 'pXij3_rZD2Oa7m8g');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}