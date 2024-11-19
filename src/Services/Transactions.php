<?php declare(strict_types=1);

namespace Idesa\Bancard\Services;

use Idesa\Bancard\Models\Card;
use Idesa\Bancard\Responses\Contracts\ChargeResponse;
use Idesa\Bancard\Responses\Contracts\ConfirmationResponse;
use Idesa\Bancard\Responses\Contracts\PreauthorizationConfirmResponse;
use Idesa\Bancard\Responses\Contracts\RollbackResponse;

trait Transactions {

    /**
     * @param  Card  $card
     * @param  int  $shop_process_id
     * @param  float  $amount
     * @param  string  $currency
     * @param  string  $description
     *
     * @return ChargeResponse
     */
    public static function charge(Card $card, int $shop_process_id, float $amount, string $currency, string $description): ChargeResponse {
        // get a new Charge request
        $request = self::newChargeRequest($card, $shop_process_id, $amount, $currency, $description);
        // execute request
        $request->execute();

        // return request response
        return $request->getResponse();
    }

    /**
     * @param  int  $shop_process_id
     *
     * @return ConfirmationResponse
     */
    public static function confirmation(int $shop_process_id): ConfirmationResponse {
        // get a new Confirmation request
        $request = self::newConfirmationRequest($shop_process_id);
        // execute request
        $request->execute();

        // return request response
        return $request->getResponse();
    }

    /**
     * @param  int  $shop_process_id
     *
     * @return PreauthorizationConfirmResponse
     */
    public static function preauthorizationConfirm(int $shop_process_id): PreauthorizationConfirmResponse {
        // get a new PreauthorizationConfirm request
        $request = self::newPreauthorizationConfirmRequest($shop_process_id);
        // execute request
        $request->execute();

        // return request response
        return $request->getResponse();
    }

    /**
     * @param  int  $shop_process_id
     *
     * @return RollbackResponse
     */
    public static function rollback(int $shop_process_id): RollbackResponse {
        // get a new Rollback request
        $request = self::newRollbackRequest($shop_process_id);
        // execute request
        $request->execute();

        // return request response
        return $request->getResponse();
    }

}
