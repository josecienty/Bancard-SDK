<?php declare(strict_types=1);

namespace Idesa\Bancard\Services;

use Idesa\Bancard\Responses\QRGenerateResponse;
use Idesa\Bancard\Responses\QRRevertResponse;

trait QR {

    /**
     * @param  int  $amount  Requested amount to Pay
     * @param  string  $description  Payment description
     *
     * @return QRGenerateResponse
     */
    public static function qr_generate(int $amount, string $description): QRGenerateResponse {
        $request = self::newQRGenerateRequest($amount, $description);
        $request->execute();

        return $request->getResponse();
    }

    /**
     * @param  string  $hook_alias  QR Payment identifier
     *
     * @return QRRevertResponse
     */
    public static function qr_revert(string $hook_alias): QRRevertResponse {
        $request = self::newQRRevertRequest($hook_alias);
        $request->execute();

        return $request->getResponse();
    }

}
