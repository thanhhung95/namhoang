<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;

class AccountKitController extends Controller
{
    
    public function __construct()
    {
          $this->appId            = config('accountkit.app_id');
          $this->client           = new GuzzleHttpClient();
          $this->appSecret        = config('accountkit.app_secret');                //config trong file ENV
          $this->endPointUrl      = config('accountkit.end_point');
          $this->tokenExchangeUrl = config('accountkit.tokenExchangeUrl');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)                                     //login voi facebook
    {
        $url = $this->tokenExchangeUrl.'grant_type=authorization_code'.
        '&code='. $request->get('code').
        "&access_token=AA|$this->appId|$this->appSecret";                       // nối chuỗi đề gửi request về facebook

        $apiRequest = $this->client->request('GET', $url);
        $body = json_decode($apiRequest->getBody());

        $this->userAccessToken = $body->access_token;
        $this->refreshInterval = $body->token_refresh_interval_sec;

        return $this->getData();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getData()                   //get data tra ve 
    {
        $request = $this->client->request('GET', $this->endPointUrl.$this->userAccessToken);
        $data = json_decode($request->getBody()); // thong tin khach hang
        return $this->CreateUser($data);
    }

    public function CreateUser($data){

        $userId = $data->id;
        $userAccessToken    = $this->userAccessToken;
        $refreshInterval    = $this->refreshInterval;
        $phone              = '0'.$data->phone->national_number;
        $accountkit         = User::where('provider','accountkit')->where('phone',$phone)->first(); // check xem tai khoan nay ton tai chua
        if ($accountkit) {                   //neu ton tai thi check status
            if ($accountkit->status == 1) {     // =1 login 0 out
                Auth::login($accountkit);       //đăng nhập auth laravel
                return redirect('/');      //redirect link sang trang chủ
            }
                return redirect('login')->with('loginFail','Tài khoản của bạn đã bị khóa');      //redirect link sang login
        }
        else{
            $temp = User::create([      // chua co tai khoan thi tạo tài khoản
                'phone'     =>  $phone,
                'provider'  =>  'accountkit',
                'lever'     =>  2,
                'status'    =>  1,
            ]);
            Auth::login($temp);
            return redirect('/');
        }
    }
}
