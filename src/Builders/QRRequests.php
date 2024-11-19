<?php declare(strict_types=1);

namespace Idesa\Bancard\Builders;

use Idesa\Bancard\Models\Currency;
use Idesa\Bancard\Models\PendingPayment;
use Idesa\Bancard\Requests\QRGenerateRequest;
use Idesa\Bancard\Requests\QRRevertRequest;

trait QRRequests {

    public static function newQRGenerateRequest(float $amount, string $description): QRGenerateRequest {
        return new QRGenerateRequest(
            bancard:         self::instance(),
            pending_payment: new PendingPayment(-1, $amount, $description, Currency::Guarani),
        );
    }

    public static function newQRRevertRequest(string $hook_alias): QRRevertRequest {
        return new QRRevertRequest(
            bancard:    self::instance(),
            hook_alias: $hook_alias,
        );
    }

}
