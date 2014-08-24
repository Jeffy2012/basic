<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;
use app\validators\PhoneValidator;
use app\models\User;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $emailValidator = new EmailValidator();
            $phoneValidator = new PhoneValidator();
            $key = 'nickname';
            if ($emailValidator->validate($this->username)) {
                $key = 'email';
            }
            if ($phoneValidator->validate($this->username)) {
                $key = 'phone_number';
            }
            $condition = array();
            $condition[$key] = $this->username;

            $this->_user = User::findOne($condition);
        }

        return $this->_user;
    }
}
