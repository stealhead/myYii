<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $expire_time
 *
 * @property User $user
 */
class UserToken extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'expire_time'], 'integer'],
            [['token'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'expire_time' => 'Expire Time',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // Access Token的过期时间30天的秒数
    const TOKEN_EXPIRY = 2592000;

    /**
     * 生成token
     *
     * @param integer $userId 用户ID
     * @return UserToken|bool
     * @throws \yii\base\Exception
     */
    public static function generateUserToken($userId) {
        $time = time();
        $userToken = new UserToken();
        $userToken->user_id = $userId;
        $userToken->expire_time = $time + self::TOKEN_EXPIRY;
        // 生成Token
        $userToken->token = \Yii::$app->getSecurity()->generateRandomString();
        if ($userToken->save()) {
            return $userToken;
        } else {
            return false;
        }
    }
}
