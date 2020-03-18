<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 03/08/2018
 * Time: 4:53 PM
 */
namespace app\swolle\lib;

class BaiduApi
{
    const AK = 'suc1TltyCOYQFveTmdmOIuIa';
    const GEOCODER_URL = 'https://api.map.baidu.com/geocoder/v2/?output=json';

    public static function getLocation($lat, $lng) {
        $url = self::GEOCODER_URL . '&ak=' . self::AK . '&location=' . $lat . ',' .$lng;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        try
        {
            $response = curl_exec($ch);
            $requestError = curl_error($ch);
            curl_close($ch);
            if ($requestError) {
                return false;
            }
            return $response;
            $responseJson = json_decode($response, true);
            if ($responseJson['status'] == 0) {
                $result = $responseJson['result'];
                return [
                    'province' => $result['addressComponent']['province'],
                    'city' => $result['addressComponent']['city'],
                    'district' => $result['addressComponent']['district'],
                ];
            }
        }
        catch (\Exception $exception) {
        }
        return false;
    }
}
//$lat = '24.4741340';
//$lng = '118.1043850';
//$result = BaiduApi::getLocation($lat, $lng);
//var_dump($result);
