<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 26/06/2018
 * Time: 1:09 PM
 */
namespace app\backend\controller;

use app\common\backend\BackendController;
use app\models\LoginForm;
use Swoole\Coroutine;
use Swoole\Coroutine\Client;
use yii\filters\AccessControl;
use yii;

class SiteController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['login', 'chat', 'hello'],
                    'allow' => true,
                ],
                [
                    'actions' => ['index', 'hello', 'logout', 'chat'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * 这是默认页
     *
     * 默认长描述
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
    public function actionHello() {
        Coroutine::create(function() {
            $client = new Client();
            if (!$client->connect('127.0.0.1', 9501, 0.5))
            {
                exit("connect failed. Error: \n");
            }
            $client->send("hello world\n");
            echo $client->recv();
            $client->close();
        });
        return $this->render('hello');
    }

    public function actionChat() {
        $param = ['name' => time()];
        return $this->render('chat', $param);
    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->redirect(['/site/login']);
    }

}