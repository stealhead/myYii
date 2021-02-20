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


class SkuPriceExcelController extends Controller
{

    public function getPath() {
        return dirname(dirname(__DIR__));
    }

    /**
     * 渠道价调整
     */
    public function actionSkuChannelPrice() {
        $inputFileName = $this->getPath() . "/models/excel/sku-price-adjust.xls";
        $outfile = $this->getPath() . '/models/sql/sku-price-adjust.json';
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
                $skuInfo = [
                    'sku_id' => trim($datum[0]),
                    'price' => trim($datum[1]) . '.00'
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

}