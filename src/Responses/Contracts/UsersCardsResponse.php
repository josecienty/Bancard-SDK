<?php declare(strict_types=1);

namespace Idesa\Bancard\Responses\Contracts;

use Idesa\Bancard\Models\Card;

interface UsersCardsResponse extends BancardResponse {

    /**
     * @return Card[] Returns the registered cards of the User
     */
    public function getCards(): array;

}
