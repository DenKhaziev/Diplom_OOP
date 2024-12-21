<?php

namespace app\controllers;

use app\model\ConnectionToDb;
use app\model\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class UserDeleteController
{
    private $qb;

    public function __construct()
    {
        $this->qb = new QueryBuilder();
    }
    public function deleteUser($args) {
        $this->qb->delete('users', $args['id']);
        header('Location: /php/Diplom_OOP/users');
        Flash::info('User has been deleted');
    }
    public function deleteComment($args) {
        $this->qb->delete('comments', $args['id']);
        header('Location: /php/Diplom_OOP/users');
//        Flash::info('User has been deleted');
    }
}