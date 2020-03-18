<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 26/06/2018
 * Time: 1:07 PM
 */
namespace app\common\backend;

use yii\filters\VerbFilter;
use yii\web\Controller;

class BackendController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] =[
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
                'file' => ['post'],
            ],
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
}