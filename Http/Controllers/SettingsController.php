<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Enums\GlobalEnums;

class SettingsController extends Controller
{
    public function public()
    {
        $settings = [
            'withdraw_fee'                      => (float)getSetting('withdraw_fee', 0),
            'zalo_link'                         => getSetting('zalo_link', '#'),
            'download_link'                     => getSetting('download_link', '#'),
            'momo_name'                         => getSetting('momo_name', ''),
            'momo_phone'                        => getSetting('momo_phone', ''),
            'bankTransfer_account_name'         => getSetting('bankTransfer_account_name', ''),
            'bankTransfer_name'                 => getSetting('bankTransfer_name', ''),
            'bankTransfer_account_id'           => getSetting('bankTransfer_account_id', ''),
        ];

        return toJson(200, GlobalEnums::API_RESPONSE_200, $settings);
    }
}
