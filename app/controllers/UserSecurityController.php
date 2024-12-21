<?php

namespace app\controllers;

use app\model\ConnectionToDb;
use app\model\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class UserSecurityController
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
    public function changePasswordView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('security', ['allUsers' => $users]);
    }


    function changePassword() {
        try {
            $this->auth->admin()->changePasswordForUserById($_POST['id'], $_POST['newPassword']);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown ID');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        Flash::success('Your password has been changed');
        header('Location: /php/Diplom_OOP/users');
    }
}