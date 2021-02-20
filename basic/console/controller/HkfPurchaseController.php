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


class HkfPurchaseController extends Controller
{
    /**
     * 经销商采购 大单
     */
    public function actionPurchaseSkuList() {
        $inputFileName = $this->getPath() . "/models/excel/hkf-purchase-20200928-1.xlsx";
        $outfile = $this->getPath() . '/models/sql/hkf-purchase-20200928-1.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = "
create temporary table tmp__hkf_purchase_order_20200928
as
select product_id, id as sku_count, specification, material, color, color as hkf_series
from product_sku a 
where 1 = 2\n";
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if ($k > 1000) {
                    break;
                }
                $productId = trim($datum[2]);
                $spe = trim($datum[3]);
                $mate = trim($datum[4]);
                $color = trim($datum[5]);
                $series = trim($datum[0]);
                $count = trim($datum[7]);
                if ($productId == "" && $spe == "" && $mate == "" && $color == "") {
                    continue;
                }
                if (!$productId || !$spe || !$mate || !$color) {
                    echo("$productId, $spe, $mate, $color\n");
                    continue;
                }
                $sql = "union select {$productId}, {$count}, '{$spe}', '{$mate}', '{$color}', '{$series}' \n";
                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ';', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }

        echo("成功\n");
    }

    /**
     * 经销商采购 大单
     */
    public function actionPurchaseSkuList2() {
        $inputFileName = $this->getPath() . "/models/excel/hkf-purchase-20200930-7.xlsx";
        $outfile = $this->getPath() . '/models/sql/hkf-purchase-20200930-7.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = "
create temporary table tmp__hkf_purchase_order_20200928
as
select product_id, id as sku_count, specification, material, color, color as hkf_series, retail_price as price, color as color_id
from product_sku a 
where 1 = 2\n";
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $array = [];
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if ($k > 2000) {
                    break;
                }
                $productId = trim($datum[2]);
                $spe = trim($datum[3]);
                $mate = trim($datum[4]);
                $color = trim($datum[5]);
                $series = trim($datum[0]);
                $count = trim($datum[7]);
                $price = trim($datum[6]);
                $colorId = trim($datum[9]);

                if ($productId == "" && $spe == "" && $mate == "" && $color == "") {
                    continue;
                }
                if (!$productId || !$spe || !$mate || !$color) {
                    echo("$productId, $spe, $mate, $color\n");
                    continue;
                }
                $uKey = $productId . '-' . $spe . $mate . $colorId . $color;

                $sql = "union select {$productId}, {$count}, '{$spe}', '{$mate}', '{$color}', '{$series}', {$price}, '{$colorId}' \n";

                if (array_key_exists($uKey, $array)) {
                    echo " $uKey\n";
                }
                $array[$uKey] = "";

                file_put_contents($outfile, $sql, FILE_APPEND);
            }
            file_put_contents($outfile, ';', FILE_APPEND);

        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }

        echo("成功\n");
    }


    public function getPath() {
        return dirname(dirname(__DIR__));
    }
}