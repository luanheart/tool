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

    public $cookie = 'NTES_SESS=L9HWfGY7c3Osrp0iwGyhVcQpkhmpuvST85KaQ6iWzfHN2z0Hh2F0SJgtFO9reAWMaTe.xpCILgcXziJS4pItJJqxX3yzG6WbrQnA8qsJ_tgkZ6TC.1Rus.s7Po2dcaBVsDWFUYy0KkMMS_j7PPB.p41_ANre73Q5su8Qhc4JcRJIa7xvYy7Ta3lp1XZX2kHU5; P_INFO=865022667@qq.com|1521685941|0|yanxuan|00&99|jis&1521685941&yanxuan#jis&320100#10#0#0|&0|yanxuan&moneykeeper|865022667@qq.com; S_INFO=1521685941|0|##|865022667@qq.com|; yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082; yx_csrf=1e41df29be73ddf3f130d2b1e949f2d5; yx_username=865022667%40qq.com; yx_sid=29e27f2b-17cd-4935-948b-d6830cfe6949; _9755xjdesxxd_=32; gdxidpyhxdE=euQXwMlz%5C8LULwuNqaTNlN%2BezDpuQb2xbYdsgmMTXnZfKw3JKG7OzAegnba2a8Jv7drzEgmEo1fqAQBLmDKSoW3G%2FCJOGw8aw6xHKmSnAZvslUz6krMSjQR7Iqx3HoV7seMDMV%5CglnXfkx5Q0WP0at%2FaPmjyJiEMD4iRtzyr5t4rxeLc%3A1521686844276';

    public $csrf_token = '1e41df29be73ddf3f130d2b1e949f2d5';

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
