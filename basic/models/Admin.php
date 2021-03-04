<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 26/06/2018
 * Time: 5:01 PM
 */

namespace app\models;


use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii;

class Admin extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }
    public function validatePassword($password){
        if(empty($password)){
            return false;
        }else{
            try {
                if($this->password != md5($password) && !Yii::$app->getSecurity()->validatePassword($password, $this->password)){
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error($e);
                return false;
            }
        }
        return true;
    }
    public static function findByUsername($username){
        return self::findOne(['username'=>$username]);
    }

    /**
     * @param int|string $userid
     * @return null|IdentityInterface|static
     */
    public static function findIdentity($userid){
        return static::findOne(['id' => $userid]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public function getId(){
        return $this->getPrimaryKey();
    }
    public function getAuthKey(){
        return true;
    }
    public function validateAuthKey($authKey){
        return $this->getAuthKey() === $authKey;
    }

    public function getRoutes() {
        if (is_null($this->_routes)) {
            $this->_routes = array_keys(Yii::$app->authManager->getPermissionsByUser($this->id));
        }
        return $this->_routes;
    }
}