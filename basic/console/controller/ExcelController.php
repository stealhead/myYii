<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 19/03/2020
 * Time: 10:50 AM
 */

namespace app\console\controller;


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
}