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

    public $cookie = 'yx_csrf=e7987fa9204114237e8c6b48f08e4c51; yx_username=865022667%40qq.com; yx_sid=19c192d7-83b8-4f9a-b8b1-b4f30af2a9b3; YanXuanLoginCookie=;NTES_SESS=96UVMkrH18ZwVjzZiHEe0z_yCPJXLZJcKcTvxklsgb0G8g50H8O5NuUhOLC7i.szvfiQpPtM9U32gluNqPMhuuYp2BAgoksZ7xK.rYjuJhUa6kftQRdwjQj4Dy8I3vmnjXsOEWA5TazzNJ14DDmQPqRJ.G7i4BxcjwrxH3qu3duMv4p_WA4fvBVPR2628a0Ec;P_INFO=865022667@qq.com|1516237522|0|yanxuan|00&99|jis&1516237522&yanxuan#jis&320100#10#0#0|&0|yanxuan&wydz_platform&moneykeeper|865022667@qq.com;S_INFO=1516237522|0|##|865022667@qq.com|;yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082;';

    public $csrf_token = 'e7987fa9204114237e8c6b48f08e4c51';

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
