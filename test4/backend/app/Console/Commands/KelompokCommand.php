<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kelompok;

class KelompokCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KelompokCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
      
        $API_SIGMA =  env('API_SIGMA');
        $API_SIGMA_V2 =  env('API_SIGMA_V2');
        $API_USER =  env('API_USER');
        $API_PASSWORD =  env('API_PASSWORD');

        $req["username"] = $API_USER;
        $req["password"] = $API_PASSWORD;
        $req["c_password"] = $API_PASSWORD;

        $logChannel = guzzleSigmaPost($req, $API_SIGMA.'login');

        $API_LOGIN_EMAIL = env('API_LOGIN_EMAIL');
        $API_LOGIN_PASSWORD = env('API_LOGIN_PASSWORD');
        
        // $reqLog["email"] = $API_LOGIN_EMAIL;
        // $reqLog["password"] = $API_LOGIN_PASSWORD;
        // $reqLog["channel_code"] = $logChannel->channel_code;

        // $login = guzzleSigmaPost($reqLog, $API_SIGMA.'access', $logChannel->token);

        $reqChannel['channel_code'] = $logChannel->channel_code;
        
        $branch = guzzleSigmaPost($reqChannel, $API_SIGMA_V2.'job_group', $logChannel->token);

        if($branch->data){
            foreach($branch->data as $k => $value){
                // dd($value);
                $result['kelompokID'] = $value->kelompokid;
                $result['kelompok'] = $value->kelompok;
                $checkData = Kelompok::where('kelompokID',$result['kelompokID'])->where('kelompok',$result['kelompok'])->first();
                if(!$checkData){
                    Kelompok::create($result);
                }
            }
        }
    }
}
