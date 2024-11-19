<?php declare(strict_types=1);

namespace Idesa\Bancard\Requests;

use GuzzleHttp\Psr7\Response;
use Idesa\Bancard\Bancard;
use Idesa\Bancard\Responses\ConfirmationResponse;
use Idesa\Bancard\Responses\Contracts\BancardResponse;

final class ConfirmationRequest extends Base\BancardRequest implements Contracts\ConfirmationRequest {

    public function __construct(
        Bancard $bancard,
        private int $shop_process_id,
    ) {
        parent::__construct($bancard);
    }

    public function getEndpoint(): string {
        return 'single_buy/confirmations';
    }

    public function getOperation(): array {
        return [
            'shop_process_id' => $this->getShopProcessId(),
        ];
    }

    protected function buildResponse(Contracts\BancardRequest $request, Response $response): BancardResponse {
        // return parsed response
        return ConfirmationResponse::fromGuzzle($request, $response);
    }

    public function getShopProcessId(): int {
        return $this->shop_process_id;
    }

}
