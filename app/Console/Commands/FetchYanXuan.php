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

    public $cookie = 'yx_csrf=118d07c4fdf7ddfad6eb0338b388bfe7; yx_username=865022667%40qq.com; yx_sid=aad63159-4ccf-4433-86fc-6e38d7f0ce95; YanXuanLoginCookie=;NTES_SESS=01klN0JIriGT_idbNLapVyFMBL3GpGX6jNkF2ufIlvmQYlSmBYhS.9V3hH5sTDIiFaTX8rce0VGqlf9.1re399swdsEXM3RTrjCzhc7r0A92JuacXgUCMXMj7pYEGFyZM4IhndPSkwii.Lzj77yXr1gLDQsTjo2NMCW2BG19GU9eFj8OdPjaFobrgqJqYwmnN;P_INFO=865022667@qq.com|1514979708|0|yanxuan|00&99|jis&1514979707&yanxuan#jis&320500#10#0#0|&0|yanxuan&note_client&moneykeeper|865022667@qq.com;S_INFO=1514979708|0|##|865022667@qq.com|;yx_aui=b8d61c05-ea24-4470-9500-84bb5a158082;';

    public $csrf_token = '118d07c4fdf7ddfad6eb0338b388bfe7';

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
