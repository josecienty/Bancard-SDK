<?php declare(strict_types=1);

namespace Idesa\Bancard\Responses\Contracts;

use Idesa\Bancard\Requests\Contracts\CardsNewRequest;
use Idesa\Bancard\Requests\Contracts\SingleBuyRequest;
use Idesa\Bancard\Requests\Contracts\UsersCardsRequest;
use Idesa\Bancard\Responses\Structs\BancardMessage;
use Psr\Http\Message\StreamInterface;

interface BancardResponse {

    /**
     * @return StreamInterface Gets the body of the response
     */
    public function getBody(): mixed;

    /**
     * @return CardsNewRequest | SingleBuyRequest | UsersCardsRequest Request made for this Response
     */
    public function getRequest(): mixed;

    /**
     * @return int Response status code
     */
    public function getStatusCode(): int;

    /**
     * @return string Bancard process status result
     */
    public function getProcessStatus(): string;

    /**
     * @return BancardMessage[] Messages from Bancard
     */
    public function getMessages(): array;

    /**
     * @return bool True if response has a success status
     */
    public function wasSuccess(): bool;

}
