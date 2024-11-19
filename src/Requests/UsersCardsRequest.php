<?php declare(strict_types=1);

namespace Idesa\Bancard\Requests;

use GuzzleHttp\Psr7\Response;
use Idesa\Bancard\Bancard;
use Idesa\Bancard\Responses\UsersCardsResponse;
use Idesa\Bancard\Responses\Contracts\BancardResponse;

final class UsersCardsRequest extends Base\BancardRequest implements Contracts\UsersCardsRequest {

    /**
     * @param  Bancard  $bancard
     * @param  int  $user_id
     */
    public function __construct(
        Bancard $bancard,
        private int $user_id,
    ) {
        parent::__construct($bancard);
    }

    public function getEndpoint(): string {
        return sprintf('users/%u/cards', $this->getUserId());
    }

    protected function buildResponse(Contracts\BancardRequest $request, Response $response): BancardResponse {
        // return parsed response
        return UsersCardsResponse::fromGuzzle($request, $response);
    }

    public function getUserId(): int {
        return $this->user_id;
    }

}
