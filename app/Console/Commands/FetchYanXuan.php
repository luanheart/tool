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

    public $cookie = 'yx_csrf=45257ba458cd537ccfbd916b7a06f686; yx_username=865022667%40qq.com; yx_sid=27f16702-aa9d-43ab-8e54-7cb9dc824798; YanXuanLoginCookie=;NTES_SESS=NqijTpPXx4XA4qwzh4sRwpTIGj9SFHWtITLq_ljp3UyTIZQ.AImQ2c6ymSGzvqibHOvYsjofN6pdZ_c2UjfycczhezTYlyEvjFp1Oj323hTfeVIUuOtr58oVLIH6rEigbJyB_7M4C4tdwVekTEG5zg35fud9Y2Q3sr.RqWIpp6CCNVkk7o4Lf2goMDfOwy5Hp;P_INFO=865022667@qq.com|1514341389|0|yanxuan|00&99|jis&1514210361&moneykeeper#jis&320500#10#0#0|&0|yanxuan&moneykeeper|865022667@qq.com;S_INFO=1514341389|0|##|865022667@qq.com|;yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082;';

    public $csrf_token = '45257ba458cd537ccfbd916b7a06f686';

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
            TplNotice::send('网易严选', '积分签到成功');
        }else{
            TplNotice::send('网易严选', '积分签到失败');
        }
    }
}
