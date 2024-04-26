<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\MasterPos;
use App\Http\Requests\AuthRequest;
use PhpParser\Node\Stmt\TryCatch;
use DB;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(AuthRequest $request){
        $recMasterPos = MasterPos::find(request()->pos);
        $pelabuhan = null;
        if($recMasterPos){
            $pelabuhan = $recMasterPos->pelabuhan;
        }
        
        try {
            if(Auth::attempt($request->only('username','password'))){
                $user = auth()->user();
                $user['shift'] = request()->shift;
                $user['pos'] = $recMasterPos->pos;
                
                Session([
                    'shift' => request()->shift,
                    'pos' => $recMasterPos->pos,
                    'pelabuhan' => $pelabuhan
                ]);

                $record = DB::table('authentication_log')
                ->where('authenticatable_id', auth()->user()->id)
                ->where('authenticatable_type', 'User')
                ->orderByDesc('id')
                ->update([
                    'shift' => request()->shift,
                    'pos' => $recMasterPos->pos
                ]);
               
                // $login = Auth::login($checkUser);
                return response()->json(['success' => true,'url' => url('dashboard')]);
            }else{
                // $logChannel = guzzleSigmaPost($req, $API_SIGMA.'login');
                // $reqLog["email"] = $request->email;
                // $reqLog["password"] = $request->password;
                // $reqLog["channel_code"] = $logChannel->channel_code;

                // $login = guzzleSigmaPost($reqLog, $API_SIGMA.'access', $logChannel->token);
                // if($login){
                //     if($login->status == 200){
                //         if($login->data){
                //             $createData['apiID'] = $login->data->id;
                //             $createData['nama'] = $login->data->nama;
                //             $createData['jeniskelamin'] = $login->data->jeniskelamin;
                //             $createData['email'] = $login->data->email;
                //             $createData['jabatanid'] = $login->data->jabatanid;
                //             $createData['jabatan'] = $login->data->jabatan;
                //             $createData['cabangid'] = $login->data->cabangid;
                //             $createData['cabang'] = $login->data->cabang;
                //             $createData['subdivisiid'] = $login->data->subdivisiid;
                //             $createData['subdivisi'] = $login->data->subdivisi;
                //             $createData['divisiid'] = $login->data->divisiid;
                //             $createData['divisi'] = $login->data->divisi;
                //             $createData['direktoratid'] = $login->data->direktoratiid;
                //             $createData['direktorat'] = $login->data->direktorat;
                            
                //             // dd($createData);
                //             // dd('on try');

                //             $checkUser = User::where('email',$login->data->email)
                //             ->first();

                //             if(!$checkUser){
                //                 $checkUser = User::create($createData);
                //             }

                //             if($checkUser){
                //                 $checkUser->setRoles();
                //                 $login = Auth::login($checkUser);
                //                 $checkUser->update($createData);
                //                 return response()->json(['success' => true,'url' => url('dashboard')]);
                //             }
                //         }
                //     }
                // }
                return response()->json([
                    'error' => [
                        'username' => ['These credentials do not match our records.'],
                        'password' => ['These credentials do not match our records.']
                    ]
                ], 422);
            }
        } catch (\Throwable $th) {
            //throw $th;
            // if(@$createData){
            //     if($checkUser){
            //         $checkUser->setRoles();
            //         $login = Auth::login($checkUser);
            //         $checkUser->update($createData);
            //         return response()->json(['success' => true,'url' => url('dashboard')]);
            //     }else{
            //         $checkUser = User::create($createData);
            //     }
            // }

            // if(Auth::attempt($request->only('username','password'))){
            //     return response()->json(['success' => true,'url' => url('dashboard')]);
            // }
            return response()->json([
                'error' => [
                    'username' => ['These credentials do not match our records.'],
                    'password' => ['These credentials do not match our records.']
                ]
            ], 422);
        }



        
    }

    public function logout()
     {
       Auth::logout();
       return redirect('/');

     }

   
}
