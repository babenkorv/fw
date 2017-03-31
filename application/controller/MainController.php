<?php

namespace application\controller;

use application\models\User;
use vendor\components\Auth;
use vendor\components\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {

        $this->render('index', [
            'a' => 22,
        ]);
    }

    public function actionSignIn()
    {
        $user = new User();

        $user->setCustomRule([
            [['email', 'password', 'repeatPassword'], 'required'],
            ['email', 'email'],
            ['password', 'equal', 'param' => ['field' => 'repeatPassword']],
        ]);

        if ($user->load() && $user->validate()) {
            if (Auth::signIn($user->email, $user->password, $user->repeatPassword)) {
                $this->redirectToUrl('/main/logIn');
            } else {
                $message = 'signIn error';
            }
            $this->render('form/SignInForm', ['user' => $user, 'message' => $message]);
        } else {
            if (!empty($user->getError())) {
                var_dump($user->getError());
            }
            $this->render('form/SignInForm', ['user' => $user, 'message' => '']);
        }
    }

    public function actionLogIn()
    {
        $user = new User();
        if ($user->load() && $user->validate()) {
            Auth::logIn($user->email, $user->password);
            $this->redirectToUrl('/');
        } else {
            if (!empty($user->getError())) {
                $message = ($user->getError());
            }
            $this->render('form/LogInForm', ['user' => $user, 'message' => $message]);
        }
    }

    public function actionLogOut()
    {
        Auth::logOut();
        $this->redirectToUrl('/');
    }
}