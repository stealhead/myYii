<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 26/06/2018
 * Time: 6:48 PM
 */

namespace app\api\controller;

use app\common\api\ApiController;
use app\common\YiiSwooleClient;
use app\models\User;
use app\models\UserToken;
use app\swoole\client\YiiWebTcpClient;
use arogachev\excel\import\basic\Importer;
use Codeception\Util\Xml;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\base\Exception;

class SiteController extends ApiController
{

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = [
            [
                'actions' => ['login', 'index', 'errors', 'swoole', 'import', 'hello', 'import-params'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
        return $behaviors;
    }

    public function actionIndex() {
        $client = (new YiiWebTcpClient())->client;
        $client->connect('127.0.0.1', 9501);
        if ($client->isConnected()) {
            $data = $_GET['word'];
            $client->send($data);
        }
        return $this->success('success');
    }

    public function actionSwoole() {
        $client = new YiiSwooleClient();
        $client->request();
        $client->receive();
    }

    public function getPath() {
        return dirname(dirname(__DIR__));
    }

    public function actionImport() {
        $inputFileName = $this->getPath() . "/models/excel/products-2.xlsx";
        $outfile = $this->getPath() . '/models/sql/b.sql';
        try {

            $spreadsheet = IOFactory::load($inputFileName);
            $a = $spreadsheet->getSheetCount();
            $sql = "create table tmp_sku
select '' as `activity_info_code`,`sku_id`,`sku_count`,`floor_price`,`cut_down_threshold`,`cycle`,`created_at`,`created_by`,`updated_at`,`updated_by`
from activity_product where 1=2 \n";
            file_put_contents($outfile, $sql);
            for ($i=0; $i<$a; $i++) {
                $spreadsheet->setActiveSheetIndex($i);
                $title = $spreadsheet->getActiveSheet()->getTitle();
                if (!preg_match("/^第.*波$/", $title)) {
                    continue;
                }
                
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $sql = '';
                $time = time();
                $activityCode = '2018_11_' . ($i + 1);
                $J = 0; // 折扣
                $L = 0; // 建议砍价人数
                foreach ($sheetData as $k => $datum) {
                    if ($k <= 2) {
                        continue;
                    }
                    if (!is_numeric($datum['F'])) {
                        continue;
                    }
                    $J = $datum['J'] ? $datum['J'] : $J;
                    if (!is_numeric($J)) {
                        $J = 0;
                    }
                    $L = isset($datum['L']) ? $datum['L'] : $L;
                    $floorPrice = round($datum['K'] * $J);
                    if ($floorPrice <= 0) {
                        $floorPrice = 1;
                    }
                    $sql .= "union select '{$activityCode}', {$datum['F']}, 5000, {$floorPrice},{$L},24,{$time},'wanggang',{$time},'wanggang'";
                    $sql .= "\n";
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ';', FILE_APPEND);

        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this->success(['result' => '成功']);
    }

    public function actionImportParams() {
        $inputFileName = $this->getPath() . "/models/products-2.xlsx";
        $outfile = $this->getPath() . '/models/sql/system_params_before.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $a = $spreadsheet->getSheetCount();
            $sql = "create temporary table tmp__system_params
                    as
                    select a.param_key, a.value
                    from system_params as a
                    where 1 = 2 \n";
            file_put_contents($outfile, $sql);
            for ($i=0; $i<$a; $i++) {
                $spreadsheet->setActiveSheetIndex($i);
                $title = $spreadsheet->getActiveSheet()->getTitle();
                if (preg_match("/^第.*波$/", $title)) {
                    continue;
                }
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $value = [];
                foreach ($sheetData as $k => $datum) {
                    if ($k <= 1) {
                        continue;
                    }
                    $value['products'][] = [
                        'product_id' => $datum['B']
                    ];
                }
                $products = json_encode($value);
                $sql = "union select '{$title}', '{$products}' \n";
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ';', FILE_APPEND);

        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this->success(['result' => '成功']);
    }

    public function actionDataImport() {
        return $this->success('a');
    }

    public function actionHello() {
        return $this->success('hello');
    }
    public function actionErrors() {
        return 'error';
    }

    public function actionLogin() {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        $user = User::findByUsername($username);
        $token = null;
        if ($user && $user->password == $password) {
            try {
                $tokenModel = UserToken::generateUserToken($user->id);
                $token = $tokenModel->token;
            } catch (Exception $e) {
                $token = 'error';
            }
        }
        return $this->success(['token' => $token]);
    }

}