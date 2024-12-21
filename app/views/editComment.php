<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->layout('layout'); ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="users.html"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/php/Diplom_OOP/users">Главная <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="page_login.html">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fa fa-comments'></i> Комментарии
            </h1>
        </div>
        <?php foreach($allUsers as $user):?>
        <?php if ($_SERVER['REQUEST_URI'] == "/php/Diplom_OOP/comment" . $user['id']):?>
            <form action="/php/Diplom_OOP/comment/done/<?php echo $user['id']?>" method="POST">
                <div class="form-group">
                    <label class="form-label fs-4">Enter new comment to user <?php echo $user['username']?></label>
                    <input type="text" name="comment" class="form-control" placeholder="new comment">
                    <input type="hidden" name="userId" value="<?php echo $user['id']?>">
                </div>
                <button type="submit">Send comment</button>
            </form>
        <?php endif;?>
        <?php endforeach;?>

        <?php foreach($allComments as $comment): ?>
        <?php if($_SERVER['REQUEST_URI'] == "/php/Diplom_OOP/comment" . $comment['userId']):?>
        <div class="d-flex align-items-center ">
            <i class="subheader-icon fa fa-comment " aria-hidden="true"></i>
            <p class="mx-5 my-2 p-3 bg-primary text-white w-25 m-2 rounded-pill border border-5"><?php echo $comment['comment']?></p>
            <a href="/php/Diplom_OOP/deleteComment/<?php echo $comment['id']?>"><i class="fa fa-trash " aria-hidden="true"></i></a>

        </div>
        <?php endif;?>
        <?php endforeach; ?>

    </main>
    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>
        <?php $this->layout('layout'); ?>
    </script>
</body>
</html>