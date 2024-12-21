<?php
namespace app\controllers;
//use Aura\SqlQuery\QueryFactory;

use app\model\ConnectionToDb;
use app\model\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

require '../vendor/autoload.php';

class HomeController
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

    public function users() {
        $isAdmin = in_array('ADMIN', $this->auth->getRoles());
        $users = $this->qb->getAll('users');
        $isAuth = $this->auth->isLoggedIn();
        $id = $this->auth->getUserId();
        echo $this->templates->render('users', ['AllUsers' => $users, 'isAuth' => $isAuth, 'isAdmin' => $isAdmin, 'id' => $id]);
    }



















}