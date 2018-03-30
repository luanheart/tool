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

    public $cookie = 'NTES_SESS=6bVggBD3lq8nEMIMTOSTIAGxLcOQFBrrgwMl3e1PqgJtoquJ_obuCKYvbZkAj5P4lzjcBma76YFGq1KCQm7vKKxBGO0qhePUA3I5yxDKnvYiEezac28TDcD.SHorFlLdDNPbWp0uMi44CnX.SSLcmQ2n5tAj.O3wDTy3_FQKF8K7l.BVp0.zlORm2GEGoiJWw; P_INFO=865022667@qq.com|1522378339|0|yanxuan|00&99|jis&1522378339&yanxuan#jis&320100#10#0#0|&0|yanxuan|865022667@qq.com; S_INFO=1522378339|0|##|865022667@qq.com|; yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082; yx_csrf=d178b2b14cbcd6e352e2cd19dc30f82e; yx_userid=26321326; yx_username=865022667%40qq.com; yx_sid=06f18fd0-2cc9-4a3f-a12a-b276258af0b2; _9755xjdesxxd_=32; gdxidpyhxdE=%2FGb9A6LmBUgROfrkEPOGRHfAf1gh6WpVgEpi%2BXl8D%2BZ1Q11zzB00BrPV%2BE%2BWlfxd%2F74wfg9zEEvNval1iE3MMV8Q96dyWXxCwMToKggsWPUqezlN73AYtuUQCBTmdDOVzO3ZO0PToee7hdOJUgQadilvN5%2Fua0yBoPounGC%2FMI32W0Mf%3A1522379242665';

    public $csrf_token = 'd178b2b14cbcd6e352e2cd19dc30f82e';

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
