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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;
use yii\base\Exception;

class SiteController extends ApiController
{
    const WEEKDAY = [1, 2, 3, 4, 5];
    const WEEKEND = [6, 0];

    const WEEK = [1, 2, 3, 4, 5, 6, 0];

    const DAY = ["09:00", "18:00"];
    const NIGHT = ["18:00", "21:00"];

    const DEFAULT_DAYS = 55;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = [
            [
                'actions' => ['login', 'index', 'errors', 'swoole', 'import', 'hello', 'import-params', 'export'],
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

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function actionExport() {
        $inputFileName = $this->getPath() . "/models/json/homer_open.json";
        $outfile = $this->getPath() . '/models/excel/homer.xlsx';

        $array = json_decode(file_get_contents($inputFileName));

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->setCellValueByColumnAndRow(1,1, '生活家ID');
        $worksheet->setCellValueByColumnAndRow(2,1, '开放时段');
        $worksheet->setCellValueByColumnAndRow(3,1, '开放状态');

        $i = 1;
        foreach ($array as $k => $item) {
            $ranges = json_decode($item->ranges, true);

            $worksheet->setCellValueByColumnAndRow(1, $i+2, $item->homer_id);

            $worksheet->setCellValueByColumnAndRow(2, $i+2, '工作日白天');
            $worksheet->setCellValueByColumnAndRow(2, $i+3, '工作日晚上');
            $worksheet->setCellValueByColumnAndRow(2, $i+4, '周末白天');
            $worksheet->setCellValueByColumnAndRow(2, $i+5, '周末晚上');

            $wordDay = false;
            $workNight = false;
            $holidayDay = false;
            $holidayNight = false;

            $date = date('Y-m-d');

            $spellDay = new Spell();
            $spellDay->startTime = self::getTimestamp(self::DAY[0], $date);
            $spellDay->endTime = self::getTimestamp(self::DAY[1], $date);

            $spellNight = new Spell();
            $spellNight->startTime = self::getTimestamp(self::NIGHT[0], $date);
            $spellNight->endTime = self::getTimestamp(self::NIGHT[1], $date);

            foreach (self::WEEK as $week) {
                if (!isset($ranges[$week])) {
                    continue;
                }
                $spell = new Spell();
                foreach ($ranges[$week] as $range) {
                    list($startTime, $endTime) = explode('-', $range);
                    $spell->startTime = self::getTimestamp($startTime, $date);
                    $spell->endTime = self::getTimestamp($endTime, $date);
                    $intersectionDay = TimeService::timeArrDiffer($spellDay, $spell);
                    $intersectionNight = TimeService::timeArrDiffer($spellNight, $spell);
                    if (in_array($week, self::WEEKDAY)) {
                        if ($intersectionDay) {
                            $wordDay = 1;
                        }
                        if ($intersectionNight) {
                            $workNight = 1;
                        }
                    } else {
                        if ($intersectionDay) {
                            $holidayDay = 1;
                        }
                        if ($intersectionNight) {
                            $holidayNight = 1;
                        }
                    }
                }
            }

            $worksheet->setCellValueByColumnAndRow(3, $i+2, $wordDay ? '开' : '关');
            $worksheet->setCellValueByColumnAndRow(3, $i+3, $workNight ? '开' : '关');
            $worksheet->setCellValueByColumnAndRow(3, $i+4, $holidayDay ? '开' : '关');
            $worksheet->setCellValueByColumnAndRow(3, $i+5, $holidayNight ? '开' : '关');

            $i += 5;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($outfile);

    }

    private static function getTimestamp($hour, $date) {
        return strtotime($date . $hour);
    }

}

class Spell {
    public $startTime; // 时间戳
    public $endTime; // 时间戳
}

class TimeService {

    public static function timeArrDiffer($spell1, $spell2) {
        $fbsStart = $spell1->startTime > $spell2->startTime && $spell1->startTime < $spell2->endTime;
        $fbsEnd = $spell1->endTime > $spell2->startTime && $spell1->endTime < $spell2->endTime;
        $sbfStart = $spell2->startTime > $spell1->startTime && $spell2->startTime < $spell1->endTime;
        $sbfEnd = $spell2->endTime > $spell1->startTime && $spell2->endTime < $spell1->endTime;
        $eq = $spell1->startTime == $spell2->startTime || $spell1->endTime == $spell2->endTime;
        return $fbsStart || $fbsEnd || $sbfStart || $sbfEnd || $eq;
    }
}