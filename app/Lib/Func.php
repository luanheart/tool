<?php
/**
 * Created by PhpStorm.
 * User: xujin
 * Date: 2017/12/27
 * Time: 上午9:57
 */

namespace App\Lib;


class Func
{
    public static function curl($url, $params = [], $type = 'POST',$cookie = null, $ua = null)
    {
        $ch = curl_init();
        if ($type == 'GET'){
            $url = $url . (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        switch ($type) {
            case "GET":
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "POST":
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                break;
            case "PUT":curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }

        if ($cookie){
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($ua){
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        }


        $res = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($res, true);
        if (empty($result)){
            return $res;
        }else{
            \Log::info("{$type}请求$url", [
                'params' => $params,
                'res' => $result
            ]);
            return $result;
        }
    }
}