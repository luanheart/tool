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

    public $cookie = 'yx_csrf=01df7ab1666092e522cd94169b6c062b; yx_username=865022667%40qq.com; yx_sid=758834e1-9440-4151-85db-5cf944d7c58d; YanXuanLoginCookie=;NTES_SESS=TZrb8wpbLeoWkjDsznamQMSms2uixaFveKIQ.WCXR3EDm8ak6mnaFirZnKfNqt.2URqh05bXTr_B8YiFo5XZiiEshBjPwXqw3QU10WPFjauug.Df2Yz1V6cumNUHnfrVYs7QeKEYuwvoHeeBHbUB8dCX_Kfi7D7xd_w4xtEotdiDiiqzW1rPj8L1dkD7fXWzy;P_INFO=865022667@qq.com|1515590439|0|yanxuan|00&99|jis&1515590439&yanxuan#jis&320100#10#0#0|&0|yanxuan&wydz_platform&moneykeeper|865022667@qq.com;S_INFO=1515590439|0|##|865022667@qq.com|;yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082;';

    public $csrf_token = '01df7ab1666092e522cd94169b6c062b';

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
