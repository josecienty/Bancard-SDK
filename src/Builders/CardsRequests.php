<?php declare(strict_types=1);

namespace Idesa\Bancard\Builders;

use Idesa\Bancard\Models\Card;
use Idesa\Bancard\Models\PendingCard;
use Idesa\Bancard\Requests\CardDeleteRequest;
use Idesa\Bancard\Requests\CardsNewRequest;
use Idesa\Bancard\Requests\UsersCardsRequest;

trait CardsRequests {

    public static function newCardsNewRequest(int $user_id, int $card_id, string $phone_no, string $email, ?string $return_url = null): CardsNewRequest {
        // build a pending card resource
        $pending_card = new PendingCard($user_id, $card_id, $phone_no, $email);

        // return the request for the card
        return new CardsNewRequest(self::instance(), $pending_card, $return_url);
    }

    public static function newUsersCardsRequest(int $user_id): UsersCardsRequest {
        // return the request
        return new UsersCardsRequest(self::instance(), $user_id);
    }

    public static function newCardDeleteRequest(Card $card): CardDeleteRequest {
        // return the request
        return new CardDeleteRequest(self::instance(), $card);
    }

}
