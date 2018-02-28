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

    public $cookie = 'YanXuanLoginCookie=;NTES_SESS=BaPSeUS_xYwRlqde.z74rrSNiTsS4yvGhj3FWlWgwQKM1TyoG1cyPHfNc3md6rUKCu67qYSnBf.jTkHPMYnNHHGHj6n65USPFJFZGPxZIp1Xm2R72ti1fe8evBBG8FG9z7qpN3lnxCCVrmrXyslvXfKv.Ioie89uMfH9MC16f97djPdcRmKW6AQLQGkK9ADS3;P_INFO=865022667@qq.com|1519657779|0|yanxuan|00&99|jis&1519657779&yanxuan#jis&320100#10#0#0|&0|yanxuan&moneykeeper|865022667@qq.com;S_INFO=1519657779|0|##|865022667@qq.com|;yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082;; yx_csrf=82a39879797fe57decbbbb76a4f00976; yx_username=865022667%40qq.com; yx_sid=7fb62619-e753-4100-85d1-40daf84a4392';

    public $csrf_token = '82a39879797fe57decbbbb76a4f00976';

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
