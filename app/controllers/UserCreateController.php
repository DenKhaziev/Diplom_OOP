<?php

namespace app\controllers;

use app\model\ConnectionToDb;
use app\model\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class UserCreateController
{

    private $templates;
    private $auth;
    private $qb;

    public function __construct()
    {
        $this->qb = new QueryBuilder();
        $this->templates = new Engine('../app/views');
        $db = new ConnectionToDb();
        $this->auth = new Auth($db->getConnection());
    }

    public function createUserView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('create_user', ['allUsers' => $users]);
    }

    public function createUser() {
        $filename = $_FILES['user_avatar']['name'];
        $filetype = $_FILES['user_avatar']['type'];
        $tmp_name = $_FILES['user_avatar']['tmp_name'];

        try {
        $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'],  function ($selector, $token)
        {
//            echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
        //                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
        //                echo '  For SMS, consider using a third-party service and a compatible SDK';
        //                d($selector, $token);
            $this->auth->confirmEmail($selector, $token);
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
                $this->qb->update('users', [
                    'work' => $_POST['work'],
                    'telephone' => $_POST['telephone'],
                    'isActive' => $_POST['isActive'],
                    'adress' => $_POST['adress'],
                    'vk' => $_POST['vk'],
                    'telegram' => $_POST['telegram'],
                    'instagram' => $_POST['instagram'],
                    'avatar' => $filename,
                ], $userId);

                if (!isset($_FILES['user_avatar']) || $_FILES['user_avatar']['error'] !== UPLOAD_ERR_OK) {
                    echo 'Upload Error';
                    exit;
                }

                $allowed_types = ['image/jpeg', 'image/png'];
                if (!in_array($filetype, $allowed_types)) {
                    echo 'Можно загружать файлы только в формате: jpg, png';
                    exit;
                }

                $target_dir = '../app/uploads/';
                $target_file = $target_dir . basename($filename);
                if (!move_uploaded_file($tmp_name, $target_file)) {
                    echo 'Error to upload a file';
                    exit;
                }
                Flash::success('Пользователь успешно добавлен');
                header('Location: /php/Diplom_OOP/users');

    }

}