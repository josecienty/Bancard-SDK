<?php declare(strict_types=1);

namespace Idesa\Bancard\Responses;

use Idesa\Bancard\Requests\Contracts\BancardRequest;

final class RollbackResponse extends Base\BancardResponse implements Contracts\RollbackResponse {

    protected static function make(BancardRequest $request, object $data): self {
        // store operation result data
        return new self($request);
    }

}
