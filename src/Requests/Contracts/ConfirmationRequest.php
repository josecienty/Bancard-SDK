<?php declare(strict_types=1);

namespace Idesa\Bancard\Requests\Contracts;

/**
 * @property int $shop_process_id
 */
interface ConfirmationRequest extends BancardRequest {

    public function getShopProcessId(): int;

}
