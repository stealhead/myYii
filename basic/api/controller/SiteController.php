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
use stdClass;
use Yii;
use yii\base\Exception;

class SiteController extends ApiController
{
//    const WEEKDAY = [1, 2, 3, 4, 5];
//    const WEEKEND = [6, 0];
//
//    const WEEK = [1, 2, 3, 4, 5, 6, 0];
//
//    const DAY = ["09:00", "18:00"];
//    const NIGHT = ["18:00", "21:00"];

    const DEFAULT_DAYS = 55;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = [
            [
                'actions' => ['login', 'index', 'errors', 'swoole', 'import', 'hello',
                    'import-params', 'export', 'import2', 'import-purchase-order',
                    'import-finance-sku-cost-config',
                    'get-sign'],
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
        $groupCode = [

        ];
        $brandIds = [

        ];
        $url = 'https://test-newadmin.wzj.com/api/s2b/mq/data-fix';
        $token = 'ATK191_5c2884380be5fe5c28843803d';
        var_dump('abc');
    }

    public function actionIndex4() {
        $orderProducts = [];
        for($i=0; $i<5; $i++) {
            $a = new stdClass();
            $a->main_order_id = '1';
            $a->customer_available_receive_date = strtotime("+{$i}day");
            var_dump(date('"Y-m-d H:i:s', $a->customer_available_receive_date));
            $orderProducts[] = $a;
        }

        $a = new stdClass();
        $a->main_order_id = '1';
        $a->customer_available_receive_date = '';
        $orderProducts[] = $a;

        $earliestTimeMapByMainOrderId = [];
        foreach($orderProducts as $orderProduct) {
            $mainOrderIdTmp = $orderProduct->main_order_id;
            if (!$orderProduct->customer_available_receive_date) {
                continue;
            }
            if (array_key_exists($mainOrderIdTmp, $earliestTimeMapByMainOrderId)) {
                $earliestTime = $earliestTimeMapByMainOrderId[$mainOrderIdTmp];
                if ($earliestTime > $orderProduct->customer_available_receive_date) {
                    $earliestTimeMapByMainOrderId[$mainOrderIdTmp] = $orderProduct->customer_available_receive_date;
                }
            } else {
                $earliestTimeMapByMainOrderId[$mainOrderIdTmp] = $orderProduct->customer_available_receive_date;
            }
        }

        var_dump(date('"Y-m-d H:i:s', $earliestTimeMapByMainOrderId[1]));

    }

    public function actionIndex1() {
        $a = new StdClass();
        $a->b = null;
        if (empty($a->b)) {
            var_dump($a);
        }
        exit;

        $a = "-VIP";
        if (preg_match_all('/.*(-VIP|-SVIP)$/', $a, $matches)) {
            var_dump($matches);
        }
        exit;

        if (preg_match('/.*(-VIP|-SVIP)$/', $a)) {
            var_dump('true');
        } else {
            var_dump('false');
        }
    }

    public function actionIndex2() {
        $random = '1902191616271158';
        $appSecret = '3f06b72ec19211e89213a28bd279ea29';
        $body = '{"is_async":1,"request_id":"M2O_8a5238a1-320e-4d15-a870-f3d60bcfd380","data":[{"order_no":"SO1902190019-1","order_type":"PK","customer_id":"WZJ","warehouse_id":"WH01","delivery_no":"","carrier_id":"","carrier_name":"","source_order_no":"","freight":"","delivery_staff":"","delivery_mobile":"","order_info":[{"order_no":"SO1902190019-1","line_no":"3","sku_code":"f1ad5cdcb51cba9692c353b98c55f51f","shipped_num":35,"shipped_time":"2019-02-19 16:16:17","delivery_no":"","batch_no":"BSN1901250002","supplier_id":"118","owner_ship":"WZJ","sale_stock_out_no":"","warehouse_code":"wh01001"}]}]}';
        $verifiedSign = static::generateSign($appSecret, $random, $body);
        return $this->success($verifiedSign);
        $logs = [];

        $a = [
            '616901AB181008001',
            '716902AB181008001',
            '121470AB181211001',
            '216926AB1901180002',
            '124980BT181029001',
            '324086FMQ181001001',
            '720741FMQ181001001',
            '220727FMQ181008001',
            '33016FMQ181011001',
            '420690FMQ181113001',
            '422559FMQ181127001',
            '118068FY181105001',
            '122033GD181126002',
            '422076HZJ181024001',
            '519085JD181012002',
            '1519472JD181012002',
            '111362JD181103002',
            '18645JD181126001',
            '28645JD181126001',
            '123079JD181127001',
            '120662KD181211001',
            '920021KY181206001',
            '120021KY181213001',
            '1710331MXS181009009',
            '217892MXS181024001',
            '317891MXS181024001',
            '110273MXS181031001',
            '217876MXS181213002',
            '310273MXS181213002',
            '125452PS190108001',
            '1774RY180929003',
            '119949YH181213001',
            '117923YMN181107001',
            '117221YMZJ181114001',
            '1524878YQ181008003',
            '616650YQ181022002',
            '116608YQ181228001'
        ];
        $b = [
            '1774RY180929003',
            '124940BT181029001',
            '124939BT181029001',
            '124980BT181029001',
            '117923YMN181107001',
            '111362JD181103002',
            '1519472JD181012002',
            '519085JD181012002',
            '616901AB181008001',
            '716902AB181008001',
            '28645JD181126001',
            '18645JD181126001',
            '123079JD181127001',
            '120662KD181211001',
            '121470AB181211001',
            '216926AB1901180002',
            '33016FMQ181011001',
            '422076HZJ181024001',
            '317891MXS181024001',
            '217892MXS181024001',
            '720741FMQ181001001',
            '110273MXS181031001',
            '118068FY181105001',
            '220727FMQ181008001',
            '117221YMZJ181114001',
            '616650YQ181022002',
            '1710331MXS181009009',
            '324086FMQ181001001',
            '422559FMQ181127001',
            '1524878YQ181008003',
            '920021KY181206001',
            '420690FMQ181113001',
            '310273MXS181213002',
            '217876MXS181213002',
            '119949YH181213001',
            '120021KY181213001',
            '116608YQ181228001',
            '122033GD181126002',
            '125452PS190108001',
        ];

        var_dump(array_diff($b, $a));

        return $this->success('success');
    }

    public function actionGetSign() {
        $random = '';
        $appSecret = '3f06b72ec19211e89213a28bd279ea29';
        $body = '{"is_async":1,"request_id":"M2O_8a5238a1-320e-4d15-a870-f3d60bcfd380","data":[{"order_no":"SO1902190019-1","order_type":"PK","customer_id":"WZJ","warehouse_id":"WH01","delivery_no":"","carrier_id":"","carrier_name":"","source_order_no":"","freight":"","delivery_staff":"","delivery_mobile":"","order_info":[{"order_no":"SO1902190019-1","line_no":"3","sku_code":"f1ad5cdcb51cba9692c353b98c55f51f","shipped_num":35,"shipped_time":"2019-02-19 16:16:17","delivery_no":"","batch_no":"BSN1901250002","supplier_id":"118","owner_ship":"WZJ","sale_stock_out_no":"","warehouse_code":"wh01001"}]}]}';
        $verifiedSign = static::generateSign($appSecret, $random, $body);
        return $this->success($verifiedSign);
    }

    private static function generateSign($appSecret, $random, $bodyString) {
        $bodyMd5 = md5($bodyString);
        $rawSignString = implode('&', array(
            $appSecret,
            $random,
            $bodyMd5
        ));
        $sign = md5($rawSignString);
        return $sign;
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


    public function actionImport2() {
        $inputFileName = $this->getPath() . "/models/excel/products-2.xlsx";
        $outfile = $this->getPath() . '/models/sql/sale_stock_mapping.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $a = $spreadsheet->getSheetCount();
            $sql = "create TEMPORARY TABLE tmp_sale_stock_mapping
                    as
                    select sale_sku_id, stock_sku_id, stock_sku_count
                    from product_sku_sale_stock_mapping
                    where 1=2 \n";
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



    public function actionImportPurchaseOrder() {
        $inputFileName = $this->getPath() . "/models/excel/purchase-2.xlsx";
        $outfile = $this->getPath() . '/models/sql/purchase-2.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = "
create temporary table tmp_purchase_order_item_status_with_code_info
select a.id, a.sequence, a.sku_id, b.code from purchase_order_item a
left join purchase_order b on a.purchase_order_guid = b.guid
where\n";
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k <= 1) {
                    continue;
                }
                $sql = "(b.code = '{$datum['0']}' and a.sequence = '{$datum['1']}' and a.sku_id = '{$datum['2']}') or\n";
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ';', FILE_APPEND);

        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this->success(['result' => '成功']);
    }

    public function actionImportFinanceSkuCostConfig() {
        $inputFileName = $this->getPath() . "/models/excel/finance-sku-cost-config.xlsx";
        $outfile = $this->getPath() . '/models/sql/finance-sku-cost-config.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = "
create temporary table tmp__sku_init_info
as
select '' as guid, a.code as sku_code, a.id as sku_id, b.title as product_title, 0.0 as sku_cost_price
from product_sku as a
join product as b on b.id = a.product_id
join brand as c on c.id = b.brandid
where 1 = 2\n";
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                $sql = "union select uuid(), '{$datum[1]}', '{$datum[0]}', '{$datum[2]}', '{$datum[4]}' \n";
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ';', FILE_APPEND);

        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this->success(['result' => '成功']);

    }


    public function actionImportProductS2bTitle() {

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