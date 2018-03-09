<?php

namespace App\Console\Commands;

use App\Lib\Func;
use App\Services\TplNotice;
use Illuminate\Console\Command;

class FetchYanXuan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yanxuan {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '网易严选自动积分签到';

    public $cookie = 'yx_csrf=a2801004cc519d2e5734c159532a69be; yx_username=865022667%40qq.com; yx_sid=758a9524-3176-4af1-84e3-acae24315e57; YanXuanLoginCookie=;NTES_SESS=8rJkjNGWUeJqo6YyVcfwFJjPwOFvIqrXK2GJ_cULSKQOfCWYqfXWIpt4X2rZ0E_9.S0elV7L8tjTC5pIkVL4ppQ3eTBFdL0dKuvEyOwHkwScxGRf0OgdZ7LRfZ.iXrtD53hJx2Q5RdskixxTi7.TCNULj2rphOhuNjdHuEQkENpOpp0ycmtFBCzmNYOhrLcya;P_INFO=865022667@qq.com|1520350914|0|yanxuan|00&99|jis&1520350914&yanxuan#jis&320100#10#0#0|&0|yanxuan&moneykeeper|865022667@qq.com;S_INFO=1520350914|0|##|865022667@qq.com|;yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082;';

    public $csrf_token = 'a2801004cc519d2e5734c159532a69be';

    public $api_points_sign = 'https://m.you.163.com/xhr/points/sign.json';

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
            case 'sign':
                $this->pointSign();
                break;
            default:
                break;
        }
    }

    //积分签到
    public function pointSign()
    {
        $res = Func::curl($this->api_points_sign . "?csrf_token={$this->csrf_token}", [], 'POST', $this->cookie);
        if (isset($res) && $res['code'] == 200){
//            TplNotice::send('网易严选', '积分签到成功');
        }else{
            TplNotice::send('网易严选该换token了', '积分签到失败');
        }
        \Log::info('网易严选积分签到结果', $res);
    }
}
