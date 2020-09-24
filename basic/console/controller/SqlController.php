<?php
namespace app\console\controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: gang
 * Date: 19/06/2020
 * Time: 9:50 AM
 */
class SqlController extends Controller {

    public function actionS2bSeriesStyle() {
        $inputFileName = $this->getPath() . "/models/excel/货客蜂系列信息.xlsx";
        $outfile = $this->getPath() . '/models/sql/s2b-series-style.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = "
create temporary table tmp__s2b_series_style
as
select id, name, style_id, brief
from s2b_series a 
where 1 = 2\n";
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if ($datum[2] == "") {
                    continue;
                }
                $sql = "union select {$datum[0]}, '{$datum[1]}', {$datum[2]}, '{$datum[4]}' \n";
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
     * 属性名称修改
     * @return string
     */
    public function actionUpdateAttributeName() {
        $inputFileName = $this->getPath() . "/models/excel/商品属性整理092101.xlsx";
        $outfile = $this->getPath() . '/models/sql/prod-update-attribute-name.sql';
        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $sql = "
create temporary table tmp__prod_attribute
as
select old_name, new_name
from prod_attribute a 
where 1 = 2\n";
            file_put_contents($outfile, $sql);
            $spreadsheet->setActiveSheetIndex(1);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach ($sheetData as $k => $datum) {
                if ($k == 0) {
                    continue;
                }
                if ($datum[3] == "") {
                    continue;
                }
                $sql = "union select '{$datum[1]}', '{$datum[3]}' \n";
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