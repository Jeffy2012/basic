<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Expression;

/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $email
 * @property string $phone_number
 * @property string $nickname
 * @property string $gender
 * @property string $password
 * @property string $activated
 * @property string $created_at
 * @property string $updated_at
 * @property string $activated_at
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'activated', 'created_at', 'updated_at', 'activated_at', 'auth_key'], 'safe'],
            [['phone_number'], 'string', 'max' => 11],
            [['nickname'], 'string', 'max' => 20],
            ['email', 'required'],
            ['email', 'string', 'max' => 100],
            [['email', 'phone_number', 'nickname'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'nickname' => 'Nickname',
            'gender' => 'Gender',
            'password' => 'Password',
            'activated' => 'Activated',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'activated_at' => 'Activated At',
            'auth_key' => 'Auth Key',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);;
                $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
            }
            return true;
        } else {
            return false;
        }
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }


}
