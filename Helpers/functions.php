<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Core\Enums\GlobalEnums;

if(!function_exists('toJson')) {
    function toJson($code = 200, $message, $data = null)
    {
        $resp = [];
        $resp['success'] = true;
        $resp['code'] = $code;
        $resp['message'] = $message;

        if(!in_array($code, [200, 201])) {
            $resp['success'] = false;
        }

        $resp['data'] = $data;

        return response()->json($resp);
    }
}

if(!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        if(!Cache::has($key)) {
            $setting = Cache::rememberForever($key, function () use ($key) {
                return \Modules\Core\Entities\Settings::where('key', $key)->first();
            });
        } else {
            $setting = Cache::get($key);
        }

        if(!$setting) {
            return $default;
        }

        return $setting->value;
    }
}

if(!function_exists('setSetting')) {
    function setSetting($key, $value = '')
    {
        $setting = \Modules\Core\Entities\Settings::where('key', $key)->first();

        if(!$setting) {
            $setting = \Modules\Core\Entities\Settings::create([
                'key' => $key,
                'value' => $value
            ]);
        } else {
            $setting->update([
                'key' => $key,
                'value' => $value
            ]);
        }

        Cache::forget($key);

        return $setting;
    }
}

if(!function_exists('typeToHtml')) {
    function typeToHtml($type) {
        $text = 'BADGE';
        $backbround = '';

        switch($type) {
            case GlobalEnums::TRANS_PURCHASE:
                $text = 'MUA GÓI';
                $backbround = 'bg-primary';
            break;
            case GlobalEnums::TRANS_RENEW:
                $text = 'GIA HẠN';
                $backbround = 'bg-info';
            break;
            case GlobalEnums::TRANS_DEPOSIT:
                $text = 'NẠP TIỀN';
                $backbround = 'bg-success';
            break;
            case GlobalEnums::TRANS_WITHDRAW:
                $text = 'RÚT TIỀN';
                $backbround = 'bg-warning';
            break;
            case GlobalEnums::TRANS_BONUS:
                $text = 'THƯỞNG';
                $backbround = 'bg-warning';
            break;
            case GlobalEnums::TRANS_AFF:
                $text = 'HOA HỒNG';
                $backbround = 'bg-warning';
            break;
        }

        return '<span class="badge '.$backbround.'">'.$text.'</span>';
    }
}

if(!function_exists('statusToHtml')) {
    function statusToHtml($status) {
        $text = 'BADGE';
        $backbround = '';

        switch($status) {
            case GlobalEnums::PAID:
                $text = 'ĐÃ THANH TOÁN';
                $backbround = 'bg-success';
            break;
            case GlobalEnums::UNPAID:
                $text = 'CHƯA THANH TOÁN';
                $backbround = 'bg-warning';
            break;
            case GlobalEnums::CANCELED:
                $text = 'THẤT BẠI';
                $backbround = 'bg-danger';
            break;
            case 'active':
                $text = 'BẬT';
                $backbround = 'bg-success';
            break;
            case 'inactive':
                $text = 'TẮT';
                $backbround = 'bg-danger';
            break;
        }

        return '<span class="badge '.$backbround.'">'.$text.'</span>';
    }
}

if(!function_exists('paymentToHtml')) {
    function gatewayToHtml($gateway) {
        $text = 'BADGE';
        $backbround = '';

        switch($gateway) {
            case GlobalEnums::GATEWAY_BALANCE:
                $text = 'SỐ DƯ TÀI KHOẢN';
            break;
            case GlobalEnums::GATEWAY_MOMO:
                $text = 'Ví MOMO';
            break;
            case GlobalEnums::GATEWAY_BANKTRANSFER:
                $text = 'Chuyển khoản';
            break;
            case GlobalEnums::GATEWAY_PHONECARD:
                $text = 'Thẻ cào';
        }

        return '<span class="font-weight-bold">'.$text.'</span>';
    }
}

if(!function_exists('getBanks')) {
    function getBanks()
    {
        $banks = [];

        if(File::exists(storage_path('app/banks.json'))) {
            $items = json_decode(File::get(storage_path('app/banks.json')), true);

            foreach($items as $item) {
                $banks[] = [
                    'name' => $item['name'].' - '.$item['code'],
                    'value' => $item['short_name'],
                ];
            }
        }

        return $banks;
    }
}

if(!function_exists('getVerName')) {
    function getVerName($id)
    {
        return \Modules\Servers\Entities\Versions::find($id)->name ?? 'Không';
    }
}

if(!function_exists('getIp')) {
    function getIp(){
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $clientIp = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $clientIp = $forward;
        }
        else{
            $clientIp = $remote;
        }

        return $clientIp;
    }
}

if(!function_exists('filter_comment')) {
    function filter_comment($comment) {
        $replace = array(
            'nứng' => 'n–––',
            'loz' => 'l––',
            'lolz' => 'l––',
            'lone' => 'l––',
            'lồz' => 'l––',
            'lồn' => 'l––',
            'Lồn' => 'L––',
            'đĩ' => 'đ–',
            'Đĩ' => 'Đ–',
            'đỉ' => 'đ–',
            'cặc' => 'c––',
            'cc' => 'c–',
            'ncc' => 'n––',
            'fuck' => 'f––k',
            'Fuck' => 'F––k',
            'bitch' => 'b–––h',
            'Bitch' => 'B–––h',
            'đụ' => 'đ–',
            'Đụ' => 'Đ–',
            'đm' => '––',
            'Đm' => '––',
            'ĐM' => '––',
            'dm' => '––',
            'Dm' => '––',
            'DM' => '––',
            'đmm' => '–––',
            'Đmm' => '–––',
            'dmm' => '–––',
            'Dmm' => '–––',
            'cl' => '––',
            'clm' => '–––',
            'clmm' => '––––',
            'clgt' => '––gt',
            'Clgt' => '––gt',
            'đéo' => 'đếch',
            'Đéo' => 'Đếch'
        );
        $comment = str_replace(array_keys($replace), $replace, $comment);
        return $comment;
    }
}
