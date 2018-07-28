<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $mobile
 * @property string $password
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 11],
            [['password', 'auth_key'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
        ];
    }

    public static function findIdentity($id) {
        return User::findOne($id);
    }

    public static function findByUsername($username) {
        return User::findOne(['username' => $username]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        /** @var UserToken $tokenModel */
        $tokenModel = UserToken::find()
            ->andWhere(['token' => $token])
            ->andWhere(['>=', 'expire_time', time()])
            ->one();
        if (!$tokenModel) {
            return null;
        }
        return self::findIdentity($tokenModel->user_id);
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}
