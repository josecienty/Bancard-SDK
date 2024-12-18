<?php declare(strict_types=1);

namespace Idesa\Bancard\Requests;

use GuzzleHttp\Psr7\Response;
use Idesa\Bancard\Bancard;
use Idesa\Bancard\Models\Card;
use Idesa\Bancard\Responses\CardDeleteResponse;
use Idesa\Bancard\Responses\Contracts\BancardResponse;

final class CardDeleteRequest extends Base\BancardRequest implements Contracts\CardDeleteRequest {

    /**
     * @param  Bancard  $bancard
     * @param  Card  $card
     */
    public function __construct(
        Bancard $bancard,
        private Card $card,
    ) {
        parent::__construct($bancard);
    }

    public function getMethod(): string {
        return 'DELETE';
    }

    public function getEndpoint(): string {
        return sprintf('users/%u/cards', $this->card->user_id);
    }

    public function getOperation(): array {
        return [
            'alias_token' => $this->card->alias_token,
        ];
    }

    protected function buildResponse(Contracts\BancardRequest $request, Response $response): BancardResponse {
        // return parsed response
        return CardDeleteResponse::fromGuzzle($request, $response);
    }

    public function getCard(): Card {
        return $this->card;
    }

    public function getUserId(): int {
        return $this->card->user_id;
    }

}
