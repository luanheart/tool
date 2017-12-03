<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Fetch115 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '115 {action}';

    //115用户id
    public $user_id = 305362419;
    public $app_ver = '7.3.2';

    public $cookie = 'T_305362419=1; Hm_lvt_44a958b429c66ae50f8bf3a9d959ccf5=1510845605,1511017344,1511889999; 115_lang=system; CID=3de74259397933cdca9e96ca32a183da; SEID=dcd5541a5775e92c001926dd6f78ee73d06731aee7c5081053c71cc5b35cb7e2704ceb83e5b83bef3b31ce0d55e8e1b58e27178f7934684d26a87aa5; UID=305362419_D1_1508218687; ssov_305362419=1_305362419_e333e080ed6a645f6144bf0764274265';

    public $token = '1d0572c8c2e89019497a0ac7b0322c09';
    public $ua = 'Mozilla/5.0; Darwin/10.0; UDown/7.3.2';

    //摇一摇api
    public $api_takespc = 'https://proapi.115.com/ios/user/takespc';
    //签到信息
    public $api_get_sign_info = 'http://web.api.115.com/user/sign';
    //签到
    public $api_sign = 'http://web.api.115.com/user/sign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '115一些api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        switch ($action){
            case 'take':
                var_dump($this->takespc());
                break;
            case 'sign':
                var_dump($this->sign());
                break;
            case 'all':
                var_dump($this->takespc());
                var_dump($this->sign());
                break;
            default:
                break;
        }


    }

    public function takespc()
    {
        $res = $this->curlGet($this->api_takespc, [
            'format' => 'json',
            'app_ver' => $this->app_ver,
            'user_id' => $this->user_id,
            'token' => $this->token
        ]);
        return $res;
    }

    public function getSignInfo($start)
    {
        $res = $this->curlGet($this->api_get_sign_info, [
            'start' => $start
        ]);
        return $res;
    }

    public function sign()
    {
        $res = $this->curlPost($this->api_sign);
        return $res;
    }

    public function curlGet($url, $params = null, $cookie = null)
    {
        if ($params){
            $url = $url . (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
        }
        if (!$cookie){
            $cookie = $this->cookie;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->ua);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
        \Log::info("GET请求$url", [
            'params' => $params,
            'res' => $res
        ]);
        return $res;
    }

    public function curlPost($url, $params = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->ua);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
        \Log::info("GET请求$url", [
            'params' => $params,
            'res' => $res
        ]);
        return $res;
    }
}
