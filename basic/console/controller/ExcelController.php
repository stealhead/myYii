<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 19/03/2020
 * Time: 10:50 AM
 */

namespace app\console\controller;


use app\models\HttpService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\console\Controller;


class ExcelController extends Controller
{
    /**
     * 渠道价调整
     */
    public function actionSkuChannelPrice() {
        $inputFileName = $this->getPath() . "/models/excel/sku-channel-price-adjust.xls";
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust.json';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = '[';
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if (!is_numeric(trim($datum[1])) || !is_numeric(trim($datum[3]))) {
                    var_dump($datum);
                    continue;
                }
                $skuInfo = [
                    'sku_id' => trim($datum[1]),
                    'channel_price' => trim($datum[3])
                ];
                $sql = json_encode($skuInfo);
                if (count($sheetData) != $k+1) {
                    $sql .= ',';
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ']', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }

    /**
     * 渠道价调整 20200325
     */
    public function actionSkuChannelPrice20200325() {
        $inputFileName = $this->getPath() . "/models/excel/sku-channel-price-adjust20200325.xls";
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust20200325.json';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = '[';
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if (!is_numeric(trim($datum[1])) || !is_numeric(trim($datum[3]))) {
                    var_dump($datum);
                    continue;
                }
                $skuInfo = [
                    'sku_id' => trim($datum[1]),
                    'channel_price' => trim($datum[3])
                ];
                $sql = json_encode($skuInfo);
                if (count($sheetData) != $k+1) {
                    $sql .= ',';
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ']', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }

    /**
     * 渠道价调整 20200414-1
     */
    public function actionSkuChannelPrice20200414First() {
        $inputFileName = $this->getPath() . "/models/excel/sku-channel-price-adjust20200414-1.xlsx";
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust20200414-1.json';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = '[';
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if (!is_numeric(trim($datum[1])) || !is_numeric(trim($datum[4]))) {
                    var_dump($datum);
                    continue;
                }
                $skuInfo = [
                    'sku_id' => trim($datum[1]),
                    'channel_price' => trim($datum[4])
                ];
                $sql = json_encode($skuInfo);
                if (count($sheetData) != $k+1) {
                    $sql .= ',';
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ']', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }
    /**
     * 渠道价调整 20200414-2
     */
    public function actionSkuChannelPrice20200414Second() {
        $inputFileName = $this->getPath() . "/models/excel/sku-channel-price-adjust20200414-2.xls";
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust20200414-2.json';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = '[';
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if (!is_numeric(trim($datum[0])) || !is_numeric(trim($datum[1]))) {
                    var_dump($datum);
                    continue;
                }
                $skuInfo = [
                    'sku_id' => trim($datum[0]),
                    'channel_price' => trim($datum[1])
                ];
                $sql = json_encode($skuInfo);
                if (count($sheetData) != $k+1) {
                    $sql .= ',';
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ']', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }

    /**
     * 渠道价调整 20200424
     */
    public function actionSkuChannelPrice20200424Second() {
        $inputFileName = $this->getPath() . "/models/excel/sku-channel-price-adjust20200424.xls";
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust20200424.json';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = '[';
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if (!is_numeric(trim($datum[0])) || !is_numeric(trim($datum[1]))) {
                    var_dump($datum);
                    continue;
                }
                $skuInfo = [
                    'sku_id' => trim($datum[0]),
                    'channel_price' => trim($datum[1])
                ];
                $sql = json_encode($skuInfo);
                if (count($sheetData) != $k+1) {
                    $sql .= ',';
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ']', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }

    /**
     * 渠道价调整 20200610
     */
    public function actionSkuChannelPrice20200610() {
        $inputFileName = $this->getPath() . "/models/excel/sku-price-channel-20200610.xls";
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust20200610.json';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = '[';
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if (!is_numeric(trim($datum[0])) || !is_numeric(trim($datum[1]))) {
                    var_dump($datum);
                    continue;
                }
                $skuInfo = [
                    'sku_id' => trim($datum[0]),
                    'channel_price' => trim($datum[1])
                ];
                $sql = json_encode($skuInfo);
                if (count($sheetData) != $k+1) {
                    $sql .= ',';
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ']', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }

    /**
     * 渠道价调整 20200710
     */
    public function actionSkuChannelPrice20200710() {
        $inputFileName = $this->getPath() . "/models/excel/sku-price-channel-20200710.xls";
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust20200710.json';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = '[';
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if (!is_numeric(trim($datum[2])) || !is_numeric(trim($datum[7]))) {
                    var_dump($datum);
                    continue;
                }
                $skuInfo = [
                    'sku_id' => trim($datum[2]),
                    'channel_price' => trim($datum[7])
                ];
                $sql = json_encode($skuInfo);
                if (count($sheetData) != $k+1) {
                    $sql .= ',';
                }
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ']', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }

    /**
     *
     */
    public function actionGetRepetition() {
        $outfile = $this->getPath() . '/models/json/sku-channel-price-adjust20200325.json';
        $sku = json_decode(file_get_contents($outfile), true);
        $skuIds = [];
        foreach ($sku as $k => $v) {
            $skuIds[] = $v['sku_id'];
        }
//        print_r($skuIds);
        $newSku = array_unique($skuIds);

        print_r($newSku);
    }



    public function getPath() {
        return dirname(dirname(__DIR__));
    }

    /**
     *
     */
    public function actionSkuStockInfo() {
        $httpService = new HttpService();
        $inputFileName = $this->getPath() . "/models/json/sku-stock.json";
        $outfile = $this->getPath() . '/models/excel/sku-stock.csv';
        $url = "https://newadmin.wzj.com/api/stock/lock-info";
        $token = 'ATK125_fd10542aaaf5f2fd105d2aa2e';
        try {
            $skuInfos = json_decode(file_get_contents($inputFileName), true);

            file_put_contents($outfile, "占用单据类型,占用单据编号,占用时间,总订单编号,客户姓名,收货人手机号,系列名称,商品名称,SPU,SKUID,材质,颜色,规格,数量\n");
            foreach ($skuInfos as  $skuInfo) {

                $data = [
                    'warehouse_id' => $skuInfo['warehouse_id'],
                    'sku_id' => $skuInfo['sku_id']
                ];
                $response = $httpService->curlGet($url, $data, $token);
                $responseObj = json_decode($response, true);
                if ($responseObj['status'] != "SUCCESS") {
                    echo "商品SKU:{$skuInfo['sku_id']} 出错\n";
                }
                foreach ($responseObj['results'] as $result) {
                    $mainOrderCode = $result['main_order_code'] ?? '';
                    $receiverName = $result['receiver_name'] ?? '';
                    $receiverMobile = $result['receiver_mobile'] ?? '';
                    $sku = "{$result['data_source_type']},{$result['data_source_order']},{$result['lock_time']},{$mainOrderCode},{$receiverName},{$receiverMobile},{$result['brand']},{$result['title']},{$result['product_id']},{$result['sku_id']},{$result['material']},{$result['color']},{$result['dimension']},{$result['num']}\n";
                    file_put_contents($outfile, $sku, FILE_APPEND);
                    echo "商品SKU:{$skuInfo['sku_id']}, 仓库:{$skuInfo['warehouse_id']} 成功\n";
                }


            }

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }

    /**
     * 同步wms库存到oms
     */
    public function actionSyncSkuStock20200515() {
        $inputFileName = $this->getPath() . "/models/excel/sync-sku-stock-20200515-test.xls";
        $outfile = $this->getPath() . '/models/sql/sync-sku-stock-20200515-test.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = "create temporary table tmp__sync_sku_stock
                    as
                    select a.sku_id, b.wms_warehouse_code, a.num
                    from stock as a
                    join warehouse b on a.warehouse_id = b.id
                    where 1 = 2 \n";
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                $skuId = trim($datum['6']);
                $warehouseCode = trim($datum['2']);
                $num = trim($datum['4']);
                if (!is_numeric($skuId) || !is_numeric($num)) {
                    var_dump($datum);
                    continue;
                }
                if ($num < 0) {
                    continue;
                }

                $sql = "union select {$skuId}, '{$warehouseCode}', {$num} \n";
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ';', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo($e->getMessage() . "\n");
        }
        echo("成功\n");
    }
}