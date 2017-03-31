<?php
$assets = \vendor\components\AssetManager::register($this->viewUniqueName);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <?= $assets['html']  ?>
</head>
<body>
<section class=" text-center top-navbar">
    <ul class="tab inline-flex">
        <?php echo ' <li class="tab-item"><a href="/main/index">Home</a></li>'; ?>
        <?php echo (\vendor\components\Auth::isGuest()) ? '<li class="tab-item"><a href="/main/signIn">SignIn</a></li>' : ''; ?>
        <?php echo (\vendor\components\Auth::isGuest()) ? '<li class="tab-item"><a href="/main/logIn">LogIn</a></li>' : ''; ?>
        <?php echo (!\vendor\components\Auth::isGuest()) ? '<li class="tab-item"><a href="/main/logOut">LogOut (' . \vendor\components\Auth::getUserEmail() . ')</a></li>' : ''; ?>
    </ul>
</section>

<?= $content ?>

<?= $assets['js'] ?>
</body>
</html>
