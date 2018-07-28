<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 26/06/2018
 * Time: 7:19 PM
 */

namespace app\common;


use yii\base\ActionFilter;
use yii;

class Auth extends ActionFilter
{
    public function beforeAction($action)
    {
        $user = Yii::$app->getUser();
        $request = Yii::$app->getRequest();
        // use HTTP Basic Auth User
        $token = $request->getAuthUser();
        if (!$token) {
            $token = array_key_exists('token', $_COOKIE) ? $_COOKIE['token'] : null; // 直接取$_COOKIE，避开Yii检查
        }
        if ($token) {
            $user->identity = $user->loginByAccessToken($token);
        }
        return true;
    }
}