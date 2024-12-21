<?php

namespace app\controllers;

use app\model\ConnectionToDb;
use app\model\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;

class UserRolesController
{

    private $auth;
    private $qb;

    public function __construct()
    {
        $this->qb = new QueryBuilder();
        $db = new ConnectionToDb();
        $this->auth = new Auth($db->getConnection());
    }
    public function getRoles() {
        d($this->auth->getRoles());
        d($this->auth->admin()->doesUserHaveRole(5, \Delight\Auth\Role::ADMIN)); // boolean
    }

    public function assignRole() {
        $this->auth->admin()->addRoleForUserById(4, \Delight\Auth\Role::ADMIN);
        echo 'Role are update to ADMIN';
    }
}