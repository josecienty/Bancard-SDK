<?php declare(strict_types=1);

namespace Idesa\Bancard\Builders;

use Idesa\Bancard\Bancard;
use Idesa\Bancard\Requests\Contracts\ConfirmationRequest;
use Idesa\Bancard\Requests\Contracts\BancardRequest;
use Idesa\Bancard\Requests\Contracts\CardDeleteRequest;
use Idesa\Bancard\Requests\Contracts\CardsNewRequest;
use Idesa\Bancard\Requests\Contracts\ChargeRequest;
use Idesa\Bancard\Requests\Contracts\PreauthorizationConfirmRequest;
use Idesa\Bancard\Requests\Contracts\SingleBuyRequest;
use Idesa\Bancard\Requests\Contracts\RollbackRequest;
use Idesa\Bancard\Requests\Contracts\UsersCardsRequest;

final class TokenBuilder {

    public static function for(BancardRequest $request): string {
        // sanitize endpoint name
        $method = sprintf("%s_%s",
            // POST => post
            strtolower($request->getMethod()),
            // users/{id}/cards => users_cards
            preg_replace(['/\d/', '/\/(\/)*/'], ['', '_'], $request->getEndpoint()));

        // return token for request
        return self::$method($request);
    }

    private static function post_single_buy(SingleBuyRequest $request): string {
        // return a token for a SingleBuy request
        return md5(sprintf('%s%u%.2F%s',
            Bancard::getPrivateKey(),
            $request->shop_process_id,
            $request->amount,
            $request->currency,
        ));
    }

    private static function post_single_buy_confirmations(ConfirmationRequest $request): string {
        // return a token for Confirmation request
        return md5(sprintf('%s%u%s',
            Bancard::getPrivateKey(),
            $request->shop_process_id,
            'get_confirmation',
        ));
    }

    private static function post_preauthorizations_confirm(PreauthorizationConfirmRequest $request): string {
        // return a token for Confirmation request
        return md5(sprintf('%s%u%s',
            Bancard::getPrivateKey(),
            $request->shop_process_id,
            'pre-authorization-confirm',
        ));
    }

    private static function post_single_buy_rollback(RollbackRequest $request): string {
        // return a token for Rollback request
        return md5(sprintf('%s%u%s%0.2F',
            Bancard::getPrivateKey(),
            $request->shop_process_id,
            'rollback',
            0,
        ));
    }

    private static function post_cards_new(CardsNewRequest $request): string {
        // return a token for a CardsNew request
        return md5(sprintf('%s%u%u%s',
            Bancard::getPrivateKey(),
            $request->card_id,
            $request->user_id,
            'request_new_card',
        ));
    }

    private static function post_users_cards(UsersCardsRequest $request): string {
        // return a token for a UserCards request
        return md5(sprintf('%s%u%s',
            Bancard::getPrivateKey(),
            $request->user_id,
            'request_user_cards',
        ));
    }

    private static function delete_users_cards(CardDeleteRequest $request): string {
        // return a token for a UserCards request
        return md5(sprintf('%s%s%u%s',
            Bancard::getPrivateKey(),
            'delete_card',
            $request->user_id,
            $request->card->alias_token,
        ));
    }

    private static function post_charge(ChargeRequest $request): string {
        // return a token for Charge request
        return md5(sprintf('%s%u%s%.2F%s%s',
            Bancard::getPrivateKey(),
            $request->shop_process_id,
            'charge',
            $request->amount,
            $request->currency,
            $request->card->alias_token,
        ));
    }

}
