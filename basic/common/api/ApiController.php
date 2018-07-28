<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 26/06/2018
 * Time: 6:48 PM
 */
namespace app\common\api;

use app\common\Auth;
use yii\filters\AccessControl;
use yii\web\Controller;
class ApiController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        // 访问控制
        $behaviors['tokenAuth'] = [
            'class' => Auth::className(),
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'denyCallback' => function() {
                echo json_encode([
                    'status' => 'TOKEN_ERROR',
                    'error_message' => '登录状态出错, 没有使用合法Token, 有问题请联系客服',
                ]);
            },
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 100,
                'height' => 35,
                'offset' => 10,
                'testLimit' => 999
            ],
        ];
    }

    protected function success($data) {
        return json_encode($data);
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return $result;
    }
}