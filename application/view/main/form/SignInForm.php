<?php
\vendor\components\AssetManager::setAsset(
    $this->viewUniqueName, [
        'css' => [
        ],
        'js' => [
            'signIn.js'
        ]
    ]
);
?>

<h3 class="text-center">Sign In</h3>

<div class="column col-6 col-sm-12 centered">
    <form class="form-horizontal" action="/main/signIn" method="post" id="signIn">
        <div class="form-group">

            <div class="col-3">
                <label class="form-label" for="email">Email</label>
            </div>
            <div class="col-9">
                <input class="form-input" type="email" name="email" id="email" placeholder="Input your email ..."/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-3">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="col-9">
                <input class="form-input" type="password" name="password" id="password"
                       placeholder="Input your password ..."/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-3">
                <label class="form-label" for="repeatPassword"">Repeat password</label>
            </div>

            <div class="col-9">
                <input class="form-input" type="password" name="repeatPassword" id=repeatPassword"
                       placeholder="Repeat your password ..."/>
            </div>
        </div>

        <input class="btn" type="submit" >

    </form>
</div>


<div class="columns" id="signInMessage">
    <div class="col-4"></div>
    <div class="column col-4">
        <?= (!empty ($message)) ? '<div class="toast toast-primary" id="signInMessage">' . ' <button class="btn btn-clear float-right" id="signInMessageClose"></button>' . $message . '</div>' : '' ?>
    </div>
</div>