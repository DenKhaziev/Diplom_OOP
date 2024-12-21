<?php
namespace app\controllers;
use FastRoute;


require '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/php/Diplom_OOP/reg', ['app\controllers\UserRegistrationController', 'registerView']);
    $r->addRoute('POST', '/php/Diplom_OOP/reg/done', ['app\controllers\UserRegistrationController', 'registration']);
    $r->addRoute('GET', '/php/Diplom_OOP/verify', ['app\controllers\UserRegistrationController', 'verify']);
    $r->addRoute('GET', '/php/Diplom_OOP/login', ['app\controllers\UserRegistrationController', 'loginView']);
    $r->addRoute('POST', '/php/Diplom_OOP/login/done', ['app\controllers\UserRegistrationController', 'login']);
    $r->addRoute('GET', '/php/Diplom_OOP/logout', ['app\controllers\UserRegistrationController', 'logout']);
    $r->addRoute('GET', '/php/Diplom_OOP/getRole', ['app\controllers\UserRolesController', 'getRoles']);
    $r->addRoute('GET', '/php/Diplom_OOP/assignRole', ['app\controllers\UserRolesController', 'assignRole']);
    $r->addRoute('GET', '/php/Diplom_OOP/users', ['app\controllers\HomeController', 'users']);
    $r->addRoute('GET', '/php/Diplom_OOP/edit{id:\d+}', ['app\controllers\UserEditController', 'editUserView']);
    $r->addRoute('POST', '/php/Diplom_OOP/edit/done/{id:\d+}', ['app\controllers\UserEditController', 'editUser']);
    $r->addRoute('GET', '/php/Diplom_OOP/status{id:\d+}', ['app\controllers\UserEditController', 'editStatusView']);
    $r->addRoute('POST', '/php/Diplom_OOP/status/done/{id:\d+}', ['app\controllers\UserEditController', 'editStatus']);
    $r->addRoute('GET', '/php/Diplom_OOP/media{id:\d+}', ['app\controllers\UserEditController', 'editAvatarView']);
    $r->addRoute('POST', '/php/Diplom_OOP/media/done/{id:\d+}', ['app\controllers\UserEditController', 'imgUpload']);
    $r->addRoute('GET', '/php/Diplom_OOP/delete/{id:\d+}', ['app\controllers\UserDeleteController', 'deleteUser']);
    $r->addRoute('GET', '/php/Diplom_OOP/create_user', ['app\controllers\UserCreateController', 'createUserView']);
    $r->addRoute('POST', '/php/Diplom_OOP/create_user/done', ['app\controllers\UserCreateController', 'createUser']);
    $r->addRoute('GET', '/php/Diplom_OOP/security{id:\d+}', ['app\controllers\UserSecurityController', 'changePasswordView']);
    $r->addRoute('POST', '/php/Diplom_OOP/security/done/{id:\d+}', ['app\controllers\UserSecurityController', 'changePassword']);
    $r->addRoute('GET', '/php/Diplom_OOP/comment{id:\d+}', ['app\controllers\UserEditController', 'editCommentView']);
    $r->addRoute('POST', '/php/Diplom_OOP/comment/done/{id:\d+}', ['app\controllers\UserEditController', 'editComment']);
    $r->addRoute('GET', '/php/Diplom_OOP/deleteComment/{id:\d+}', ['app\controllers\UserDeleteController', 'deleteComment']);

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 404;
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $controller = new $handler[0];
        call_user_func([$controller, $handler[1]], $vars); // идем в контроллер (передаем именно новый экземпляр класса - $controller, вызываем метод который идет с $handler[1] и передаем параметры $vars
        break;
}