<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;
use app\validators\PhoneValidator;
use app\models\User;

class SignupForm extends Model
{
    public $email;
    public $password;
    public $passwordRepeat;
    public $verifyCode;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim',],
            ['email', 'required'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.',],
            ['email', 'email'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password'],
            [['verifyCode'], 'captcha'],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {

            $user = new User();
            $user->email = $this->email;
            $user->password = $this->password;
            if ($user->save()) {
                return $user;
            } else {
                return null;
            }
        }

        return null;
    }
}