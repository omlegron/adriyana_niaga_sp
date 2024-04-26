<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cabang;
class CabangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CabangCommand';

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
        dd($logChannel);

        $API_LOGIN_EMAIL = env('API_LOGIN_EMAIL');
        $API_LOGIN_PASSWORD = env('API_LOGIN_PASSWORD');
        
        // $reqLog["email"] = $API_LOGIN_EMAIL;
        // $reqLog["password"] = $API_LOGIN_PASSWORD;
        // $reqLog["channel_code"] = $logChannel->channel_code;

        // $login = guzzleSigmaPost($reqLog, $API_SIGMA.'access', $logChannel->token);

        $reqChannel['channel_code'] = $logChannel->channel_code;
        
        $branch = guzzleSigmaPost($reqChannel, $API_SIGMA_V2.'branch', $logChannel->token);

        // dd($branch->data);
        if($branch->data){
            foreach($branch->data as $k => $value){
                // dd($value);
                $result['cabangID'] = $value->cabangid;
                $result['cabang'] = $value->cabang;
                $checkData = Cabang::where('cabangID',$result['cabangID'])->where('cabang',$result['cabang'])->first();
                if(!$checkData){
                    Cabang::create($result);
                }
            }
        }
        
        // dd($record);
    }
}
