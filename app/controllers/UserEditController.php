<?php

namespace app\controllers;

use app\model\ConnectionToDb;
use app\model\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class UserEditController
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
    public function editUserView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('edit', ['allUsers' => $users]);
    }

    public function editStatusView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('status', ['allUsers' => $users]);
    }
    public function editAvatarView() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('media', ['allUsers' => $users]);
    }

    public function editCommentView() {
        $users = $this->qb->getAll('users');
        $comments = $this->qb->getAll('comments');
        echo $this->templates->render('editComment', ['allComments' => $comments, 'allUsers' => $users]);
    }

    public function editComment($vars) {
        $this->qb->insert('comments', [
            'comment' => $_POST['comment'],
            'userId' => $_POST['userId']

        ]);
//        d($_POST); die;
        header('Location: /php/Diplom_OOP/comment' . $vars['id']);

    }

    public function editUser($args) {
        $this->qb->update('users', [
            'username' => $_POST['username'],
            'work' => $_POST['work'],
            'telephone' => $_POST['telephone'],
            'adress' => $_POST['adress'],
        ], $args['id'] );
//        $flash = new Flash();
//        $flash->success('Профиль успешно обновлен!');
        Flash::success('Профиль успешно обновлен!');
        header('Location: /php/Diplom_OOP/users');

    }

    public function editStatus($args) {
        $this->qb->update('users', [
            'isActive' => $_POST['isActive'],
        ], $args['id']);
        Flash::success('Статус пользователя успешно изменен!');
        header('Location: /php/Diplom_OOP/users');
    }

    function imgUpload($args) {
        $filename = $_FILES['user_avatar']['name'];
        $filetype = $_FILES['user_avatar']['type'];
        $tmp_name = $_FILES['user_avatar']['tmp_name'];

        if (!isset($_FILES['user_avatar']) || $_FILES['user_avatar']['error'] !== UPLOAD_ERR_OK) {
            echo 'Upload Error';
            exit;
        }

        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($filetype, $allowed_types)) {
            echo 'Можно загружать файлы только в формате: jpg, png';
            exit;
        }

        $this->qb->update('users', [
            'avatar' => $filename,
        ], $args['id']);

        $target_dir = '../app/uploads/';
        $target_file = $target_dir . basename($filename);
        if (!move_uploaded_file($tmp_name, $target_file)) {
            echo 'Error to upload a file';
            exit;
        }
        header('Location: /php/Diplom_OOP/users');
    }
}