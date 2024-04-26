<?php
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Carbon\Carbon;

function sendMail($view, $subject, $email, $record = [], $users = []){
    Mail::to($email)->send(new SendMail($view, $subject, $email, $record, $users));
}

function sendMailQueue($view, $subject, $email, $record = [], $users = []){
    Mail::to($email)->queue(new SendMail($view, $subject, $email, $record, $users));
}

function existUrl($path=null) {
    $paths = asset('storage/'.$path);
    if(@getimagesize($paths) || file_exists($paths)){
        $thumbnail = $paths;
    }else{
        $thumbnail = asset('no-images.png');
    }
    return $thumbnail;
}


function moneyFormat($money){
    if(is_null($money)){
        return 'Rp. 0';
    }

    if($money > 0){
        return 'Rp. '.number_format((float)$money,0,",",".");
    }else{
        return 'Rp. 0';
    }
}

function moneyFormatWthCurrency($money){
    return number_format($money,0,",",".");
}


function textarea($text)
{
  $new = '';

  $new = str_replace("\n", "<br>", $text);

  return $new;
}

function replaceToUnderscore($text){
    $new = '';
    $new = str_replace(" ", "_", $text);
    return $new;    
}


function readMoreText($value, $maxLength = 150){
    $return = textarea($value);
    if (strlen($value) > $maxLength) {
        $return = substr(textarea($value), 0, $maxLength);
        $readmore = substr(textarea($value), $maxLength);

        $return .= '<a href="javascript: void(0)" class="read-more" onclick="$(this).parent().find(\'.read-more-cage\').show(); $(this).hide()" style="color: #009245">&nbsp;&nbsp; Selengkapnya... </a>';

        $readless = '<a href="javascript: void(0)" class="read-less" onclick="$(this).parent().parent().find(\'.read-more\').show(); $(this).parent().hide()" style="color: #009245">&nbsp;&nbsp; Kecilkan... </a>';

        $return = "<span>{$return}<span style='display: none' class='read-more-cage'>{$readmore} {$readless}</span></span>";
    }
    return $return;
}

function makeButton($params = []){
    $settings = [
        'id'    => '',
        'class'    => 'blue',
        'label'    => 'Button',
        'tooltip'  => '',
        'target'   => url('/'),
        'disabled' => '',
        'url' => '',
        'value' => '',
    ];

    $btn = '';
    $datas = '';
    $attrs = '';

    if (isset($params['datas'])) {
        foreach ($params['datas'] as $k => $v) {
            $datas .= " data-{$k}=\"{$v}\"";
        }
    }

    if (isset($params['attributes'])) {
        foreach ($params['attributes'] as $k => $v) {
            $attrs .= " {$k}=\"{$v}\"";
        }
    }

    switch ($params['type']) {
        case "deleteAll":

        $settings['class']   = 'removeAll checkbox-select';
        $settings['label']   = 'checkbox checkbox-outline checkbox-outline-2x checkbox-primary';
        $settings['tooltip'] = 'Hapus Data';
        $settings['disabled'] = '';

        $params  = array_merge($settings, $params);
        $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";
        $btn = "<label class='{$params['label']}'>
        <input type=\"checkbox\" name=\"id[]\" value='{$params['value']}' class='{$params['class']}' {$datas}{$attrs}{$extends}/>
        <span></span>
        </label>\n";
        break;

        case "delete":
        $settings['class']   = 'm-l btn btn-icon btn-danger btn-sm delete-data btn-hover-light';
        $settings['label']   = '<i class="flaticon-delete-1 "></i>';
        $settings['tooltip'] = 'Hapus Data';
        $settings['disabled'] = '';

        $params  = array_merge($settings, $params);
        $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";
        $btn = "<a href=\"#\" {$datas}{$attrs}{$extends} class='{$params['class']} ".($params['disabled'] ? 'disabled' : '')."' data-toggle=\"tooltip\" data-theme=\"dark\" title=\"{$params['tooltip']}\">
        {$params['label']}
        </a>\n";
        break;
        
        case "modal":
        $settings['onClick'] = '';
        $settings['class']   = 'btn btn-icon btn-warning btn-sm btn-hover-light custome-modal';
        $settings['label']   = '<i class="flaticon-edit-1"></i>';
        $settings['tooltip'] = 'Ubah Data';
        $settings['modal'] = '#largeModal';

        $params  = array_merge($settings, $params);
        $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

        $btn = "<button type='button' {$datas}{$attrs}{$extends} 
        class='{$params['class']} ".($params['disabled'] ? 'disabled' : '')."' 
        onclick='{$params['onClick']}' 
        data-toggle=\"tooltip\" 
        data-theme=\"dark\"
        data-modal=\"{$params['modal']}\"
        data-url=\"{$params['url']}\"
        title=\"{$params['tooltip']}\"
        {$params['disabled']}
        >
        {$params['label']}
        </button>\n";
        break;
        
        case "url":
        default:
        $settings['class']   = 'btn btn-icon btn-warning btn-sm btn-hover-light';
        $settings['label']   = '<i class="flaticon-edit-1 "></i>';
        $settings['tooltip'] = 'Ubah Data';

        $params  = array_merge($settings, $params);
        $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

        $btn = "<a href=\"{$params['url']}\" {$datas}{$attrs}{$extends} 
        class='{$params['class']}' 
        data-toggle=\"tooltip\" 
        data-theme=\"dark\"
        title=\"{$params['tooltip']}\"
        {$params['disabled']} 
        >
        {$params['label']}
        </a>\n";
        break;

        case "download":
        $settings['class']   = 'btn btn-icon btn-primary btn-sm btn-hover-light';
        $settings['label']   = '<i class="flaticon-download "></i>';
        $settings['tooltip'] = 'Download Data';

        $params  = array_merge($settings, $params);
        $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

        $btn = "<a href=\"{$params['url']}\" target='_blank' {$datas}{$attrs}{$extends} 
        class='{$params['class']}' 
        data-toggle=\"tooltip\" 
        data-theme=\"dark\"
        title=\"{$params['tooltip']}\"
        {$params['disabled']} 
        >
        {$params['label']}
        </a>\n";
        break;
    }

    return $btn;
}

function ButtonSED($data, $route_type, $permission_type)
{
    $button = '';
    // $button = ' <a class="btn btn-icon btn-light btn-sm btn-hover-warning" href="'.  route($route_type.'.show',Crypt::encrypt($data->id)) .'" data-toggle="tooltip"  data-theme="dark" title="Show">
    // '. Metronic::getSVGController("media/svg/icons/General/Settings-1.svg", "svg-icon-md svg-icon-warning") .'
    // </a>';
    if(auth()->user()->can($permission_type.'.edit')){
        $button .= ' <a class="btn btn-icon btn-light btn-sm btn-hover-primary" href="'.  route($route_type.'.edit',Crypt::encrypt($data->id)) .'" data-toggle="tooltip"  data-theme="dark" title="Edit">
        '. Metronic::getSVGController("media/svg/icons/Communication/Write.svg", "svg-icon-md svg-icon-primary") .'
        </a>';
    }
    if(auth()->user()->can($permission_type.'.delete')){
        $button .= ' <button class="btn btn-icon btn-light btn-sm btn-delete btn-hover-danger" data-remote="'. route($route_type.'.destroy', Crypt::encrypt($data->id)) .'" data-toggle="tooltip"  data-theme="dark" title="Delete">
        '. Metronic::getSVGController("media/svg/icons/General/Trash.svg", "svg-icon-md svg-icon-danger") .'
        </button>';
    }

    return $button;
}

function eventType($type)
{
    $return = "";
    switch ($type) {
        case 'created':
        $return = '<span class="label label-success label-pill label-inline mr-2">'.$type.'</span>';
        break;

        case 'updated':
        $return = '<span class="label label-warning label-pill label-inline mr-2">'.$type.'</span>';
        break;

        case 'deleted':
        $return = '<span class="label label-danger label-pill label-inline mr-2">'.$type.'</span>';
        break;
        default:
        # code...
        break;
    }

    return $return;
}

function createdAt($created)
{
    return "<b>". date('Y-m-d H:i:s', strtotime($created)) . "</b>";
}

function DateToString($date)
{
    if (!isset($date)) {
        return '-';
    }
    $tgl    = $date->format('Y-m-d');
    $pecah  = explode("-", $tgl);
    $thnStr = $pecah[0];
    $tglStr = $pecah[2]."";
    $blnStr = "";
    switch ($pecah[1]) {
        case '01':
        $blnStr = 'Januari';
        break;
        case '02':
        $blnStr = 'Februari';
        break;
        case '03':
        $blnStr = 'Maret';
        break;
        case '04':
        $blnStr = 'April';
        break;
        case '05':
        $blnStr = 'Mai';
        break;
        case '06':
        $blnStr = 'Juni';
        break;
        case '07':
        $blnStr = 'Juli';
        break;
        case '08':
        $blnStr = 'Agustus';
        break;
        case '09':
        $blnStr = 'September';
        break;
        case '10':
        $blnStr = 'Oktober';
        break;
        case '11':
        $blnStr = 'November';
        break;
        case '12':
        $blnStr = 'Desember';
        break;
    }

    return $tglStr." ".$blnStr." ".$thnStr;
}

function toPercent($data){
    $result = null;
    if($data){
        return $data * 100;
    }

    return $result;
}

function getYear(){
    $year = [];
    for($i = 1995; $i <= date('Y)'); $i++){
        $year[$i] = $i;
    }

    return $year;
}

function getPlate($res){
    $data = [
        '15th Forward',
        '14th',
        '13th',
        '12th',
        '11th',
        '10th',
        '9th',
        '8th',
        '7th',
        '6th',
        '5th',
        '4th',
        '3th',
        '2nd',
        '1st',
        'Amidships',
        '1st aft',
        '2nd`',
        '3th`',
        '4th`',
        '5th`',
        '6th`',
        '7th`',
        '8th`',
        '9th`',
        '10th`',
        '11th`',
        '12th`',
        '13th`',
        '14th`',
        '15th`',
    ];
    
    return $data[$res];
}

function getStrake($res){
    $data = [
        'Keel Plate',
        'Lajur A',
        'Lajur B',
        'Lajur C',
        'Lajur D',
        'Lajur E',
        'Lajur F',
    ];
    
    return $data[$res]; 
}

function getStrakeLeft($res){
    $data = [
        'Lajur A`',
        'Lajur B`',
        'Lajur C`',
        'Lajur D`',
        'Lajur E`',
        'Lajur F`',
    ];
    
    return $data[$res]; 
}

// API SIGMA
function guzzleSigmaPost($request = [], $url = null, $token = null){
    // dd($request);
    $client = new Client();
    $apiUrl = Config('app.url_api');
    $option = [
        'body' => json_encode($request),
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ],
        'verify' => false
    ];

    $result = $client->post($url,$option)->getBody();
    return json_decode($result);
}

function readableMetric($kg = 0)
{
    $amt = $kg * pow(1000, 3);
    $s = array('Kg','Ton');
    $e = floor(log10($amt)/log10(1000));
    if($amt == 0){
        $resultAmt = 0;
    }else{
        $resultAmt = $amt/pow(1000, $e);
    }

    if(((int)$e == 2) OR ((int)$e == 3) OR ((int)$e == 4) OR (int)$e == 5){
        $e = 0;
    }

    $unit = isset($s[$e]) ? $s[$e] : 'Kg';
    return [
        "amount" => $resultAmt,
        "unit"   => ($resultAmt > 0) ? $unit : ''
    ];
}


function getRoute()
{
    return (@\Route::getCurrentRoute()->controller->route) ? \Route::getCurrentRoute()->controller->route : null;
}

function getRouteMid()
{
    $route = (@\Route::getCurrentRoute()->controller->route) ? \Route::getCurrentRoute()->controller->route : null;
    $data = [
        $route . ".index",
        $route . ".create",
        $route . ".edit",
        $route . ".show",
        $route . ".delete",
        $route . ".download",
        $route . ".approval",
        $route . ".reviewer",
        $route . ".review",
        $route . ".hapus-cluster-data",
        $route . ".cluster-data",
        $route . ".input-replating",
        $route . ".hitung-estimasi",
        $route . ".visualisasi-hasil-ut",
        $route . ".hasil-ut",
        $route . ".list",
        $route . ".detail",
        $route . ".permission",
    ];

    return $data;
}

function getRouteGroup()
{
    $routeCollect = [];
    foreach (\Route::getRoutes() as $route) {
        if (!is_array($route->getName())) {
            if ($route->getName() != null) {
                $realRoute = strtok($route->getName(), '.');
                if (isset($routeCollect[$realRoute])) {
                    array_push($routeCollect[$realRoute], $route->getName());
                } else {
                    $routeCollect[$realRoute] = [$realRoute . '.index'];
                }
            }
        }
    }
    return $routeCollect;
}

function checkPerms($data)
{
    $return = false;
    $mergeData = getRoute() . '.' . $data;
    if (\Auth::check()) {
        $check = auth()->user()->can($mergeData);
        if (@$check) {
            $return = true;
        }
    }
    return $return;
}

function getPermLetter($text)
{
    $return = ltrim(stristr($text, '.'), '.');
    $return = textSpace($return);
    $return = ucwords($return);
    return $return;
}

function textSpace($text, string $divider = '_')
{
    return str_replace($divider, ' ', $text);
}

function getYoutubeEmbedUrl($url)
{
     $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
     $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

    if (preg_match($longUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }

    if (preg_match($shortUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }
    return 'https://www.youtube.com/embed/' . $youtube_id ;
}

function formSandar($data = null){
    $res = [
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 1'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 2'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 3'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 4'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 5'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga LCM 1'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga LCM 2'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga LCM 3'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga LCM 4'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga LCM 5'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 1'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 2'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 3'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 4'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 5'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 6'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan Pasir (> 1000GT) 1'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan Pasir (> 1000GT) 2'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan Pasir (> 1000GT) 3'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan Pasir (< 1000GT) 4'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan Pasir (< 1000GT) 5'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan Pasir (< 1000GT) 6'
        ]
    ];

    return $res;
}

function formAirTawar($data = null){
    $res = [
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 1'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 2'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 3'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 4'
        ],
        [
            "pos" => ['Pos 1', 'Pos 2'],
            "dermaga" => 'Dermaga 5'
        ],
        [
            "pos" => ['Pos 2'],
            "dermaga" => 'Dermaga LCM 1'
        ],
        [
            "pos" => ['Pos 2'],
            "dermaga" => 'Dermaga LCM 2'
        ],
        [
            "pos" => ['Pos 2'],
            "dermaga" => 'Dermaga LCM 3'
        ],
        [
            "pos" => ['Pos 2'],
            "dermaga" => 'Dermaga LCM 4'
        ],
        [
            "pos" => ['Pos 2'],
            "dermaga" => 'Dermaga LCM 5'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 1'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 2'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 3'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 4'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 5'
        ],
        [
            "pos" => ['Pos 3'],
            "dermaga" => 'Dermaga Bulusan 6'
        ]
    ];

    return $res;
}


function getPos($data = null){
    $resData = '-';
    if($data == 'Pos 1'){
        $resData = 'Pos 1 - Ketapang';
    }else if($data == 'Pos 2'){
        $resData = 'Pos 2 - Gilimanuk';
    }else if($data == 'Pos 3'){
        $resData = 'Pos 3 - Bulusan';
    }

    return $resData;
}

function getShift($data = null){
    $return  = '-';
    if($data == 'Shift 1'){
        $return  = 'Shift 1 (07.00-19.00 WIB)';
    }else if($data == 'Shift 2'){
        $return  = 'Shift 2 (19.00-07.00 WIB)';
    }else if($data == 'Shift 3'){
        $return  = 'Shift 3 (02.00-08.00 WIB)';
    }

    return $return;
}

function format_indo($date){
    date_default_timezone_set('Asia/Jakarta');
    // array hari dan bulan
    $Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
    $Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

    // pemisahan tahun, bulan, hari, dan waktu
    $tahun = substr($date,0,4);
    $bulan = substr($date,5,2);
    $tgl = substr($date,8,2);
    $waktu = substr($date,11,5);
    $hari = date("w",strtotime($date));
    $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;

    return $result;
  }

  function checkPelabuhan($data){
    $return = '';
    if($data == 'Pos 1'){
        $return = 'Pelabuhan Ketapang';
    }else if($data == 'Pos 2'){
        $return = 'Pelabuhan Gilimanuk';
    }else if($data == 'Pos 3'){
        $return = 'Pelabuhan Bulusan';
    }

    return $return;
  }

  function kodeUniq($uniq = '-', $total = 0){
    $date = Carbon::now()->format('Ymd');
    //JS20240123+nomor urut
    //AT20240123+nomor urut
    $kdPel = kodePelabuhan(\Session::get('pos'));
    // dd($kdPel);
    if($total == 0){
        $total = 1;
    }
    $return = $uniq.$kdPel.$date.$total;
    return $return;
  }

  function kodePelabuhan($data = null){
    $return = '';
    if($data == 'Pos 1'){
        $return = 'KET';
    }else if($data == 'Pos 2'){
        $return = 'GIL';
    }else if($data == 'Pos 3'){
        $return = 'BUL';
    }

    return $return;
  }

  function getApi($url, $request = []){
    $client = new Client();
    
    $response = $client->get(Config('app.urlApi').$url,[
        'query' => $request
    ]);
    
    $data = $response->getBody()->getContents();
    $response_json = json_decode($data);
    $data = $response_json->data;

    return $data;
  }

  function delApi($url, $request = []){
    $client = new Client();
    
    $response = $client->delete(Config('app.urlApi').$url);
    
    $data = $response->getBody()->getContents();
    $response_json = json_decode($data);
    $data = $response_json->data;

    return $data;
  }