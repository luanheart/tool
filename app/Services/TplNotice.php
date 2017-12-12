<?php
/**
 * Created by PhpStorm.
 * User: xujin
 * Date: 2017/12/12
 * Time: 下午9:18
 */

namespace App\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TplNotice
{
    //使用惠氏的模板消息进行通知
    public static function send($title, $content = '提醒内容', $remark = '', $url = '')
    {
        $params = [
            'openid' => 'owtN6jkVHmd-ctim1pBNtWSqmXkU',
            'title' => $title,
            'content' => $content,
            'remark' => $remark,
            'url' => $url
        ];
        $params['token'] = self::getToken($params);
        $post_url = 'http://mama-weiketang.e-shopwyeth.com/api/hd/sendNoticeTpl';

        $client = new Client();
        try{
            $res = $client->request('POST', $post_url, ['form_params' => $params]);
        }catch (RequestException $exception){
            try{
                $res = $client->request('POST', $post_url, ['form_params' => $params]);
            }catch (RequestException $exception){
                return false;
            }
        }
        $res = json_decode($res->getBody(), true);
        return isset($res['ret']) && $res['ret'] == 1;
    }

    public static function getToken($params){
        unset($params['token']);
        ksort($params);
        $tmp = '';
        foreach ($params as $key => $value){
            $tmp .= $key . $value;
        }
        $tmp .= 'yCj8w0I13uNqm4VUyZHATjUKFdfQvS9W';
        $token = md5($tmp);
        return $token;
    }
}