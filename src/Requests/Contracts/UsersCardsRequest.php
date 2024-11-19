<?php declare(strict_types=1);

namespace Idesa\Bancard\Requests\Contracts;

/**
 * @property int $user_id
 */
interface UsersCardsRequest {

    public function getUserId(): int;

}
