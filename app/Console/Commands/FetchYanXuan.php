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

    public $cookie = 'YanXuanLoginCookie=;NTES_SESS=L1kpRWM3ePAoY5l4FixGd9zXb1SdzwScq5KaQ6iWzfHN2z0Hh2F0SJgtFO9reAWMaTe.xpCILgcXziJS4pItJJrkYrd.stqepK.Ezel.BCgOZ6TC.1Rus.s7Po2dcaBVsDWFUYy0KkMMS_j7PPB.p41_ANre73Q5su8Qhc4JcRJIa7xvYy7Ta3lp1XZX2kHU5;P_INFO=865022667@qq.com|1516867464|0|yanxuan|00&99|jis&1516867464&yanxuan#jis&320500#10#0#0|&0|yanxuan&wydz_platform&moneykeeper|865022667@qq.com;S_INFO=1516867464|0|##|865022667@qq.com|;yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082;; yx_csrf=4c5e375029f83e45d7453ca928481d50; yx_username=865022667%40qq.com; yx_sid=b9dbaa81-da14-42b4-a7cb-07411690b997';

    public $csrf_token = '4c5e375029f83e45d7453ca928481d50';

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
