<?php
namespace Modules\Core\Enums;

class GlobalEnums
{
    public const API_RESPONSE_500 = 'Đã xảy ra lỗi, vui lòng quay lại sau hoặc liên hệ quản trị viên.';
    public const API_RESPONSE_404 = 'Không tìm thấy dữ liệu.';
    public const API_RESPONSE_403 = 'Bạn không có quyền truy cập tính năng này.';
    public const API_RESPONSE_200 = 'Thành công';
    public const API_RESPONSE_201 = 'Khởi tạo thành công';
    public const API_RESPONSE_422 = 'Dữ liệu không hợp lệ';

    //Transaction Types
    public const TRANS_RENEW    = 'renew';
    public const TRANS_PURCHASE = 'purchase';
    public const TRANS_DEPOSIT  = 'deposit';
    public const TRANS_WITHDRAW = 'withdraw';
    public const TRANS_BONUS    = 'bonus';
    public const TRANS_AFF      = 'affiliate';

    //Payment Gateway
    public const GATEWAY_BALANCE = 'balance';
    public const GATEWAY_MOMO = 'momo';
    public const GATEWAY_PHONECARD = 'phoneCard';
    public const GATEWAY_IBANKING = 'ibanking';
    public const GATEWAY_BANKTRANSFER = 'bankTransfer';

    //Status
    public const PAID = 'paid';
    public const UNPAID = 'unpaid';
    public const CANCELED = 'canceled';
}
