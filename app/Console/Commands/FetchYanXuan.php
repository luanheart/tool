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

    public $cookie = 'NTES_SESS=4TyW7TDDCC8pMjQjSiXJ0CSUMHVkR2EH7RGpnQBwHyjU6H1js6r1gX0Wr7qa3lwhpo3VKTYt40dZHBXg_TtWXXaxuaCVFWJ3TPQUX75b2lXS.QoYVL92FVFvfe6CdpMSFbwr5ui1GxhhgDOvffMVT_LDlUa3vInRF2knsd_Xd9XtpvKPuivopImTLZ.Z6xj5R; P_INFO=865022667@qq.com|1520993664|0|yanxuan|00&99|jis&1520993664&yanxuan#jis&320500#10#0#0|&0|yanxuan&moneykeeper|865022667@qq.com; S_INFO=1520993664|0|##|865022667@qq.com|; yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082; yx_csrf=b4a60f5828b4fe8ed21b74becb0f7f0d; yx_username=865022667%40qq.com; yx_sid=a13b2eb6-5128-4a39-9783-e8c10770a56f; _9755xjdesxxd_=32; gdxidpyhxdE=37E%5CO%2BkZL8c762kr7uic4WvXrzXATRCNAb6C8Knku4p8Twlp0tBDyHH3oqvqqco430Nq%2BuNyOaepnD8RDn108T1qTz8%2BA%2F89ZXExlJ2M25jEEqTa%2BKCurxrb88AySTjPrx6DubNnbY6qOeaooa2RYUUG%2F4jSeP7t2mOuucD%5C4emUv9Ek%3A1521001060932';

    public $csrf_token = 'b4a60f5828b4fe8ed21b74becb0f7f0d';

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
