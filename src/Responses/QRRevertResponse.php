<?php declare(strict_types=1);

namespace Idesa\Bancard\Responses;

use Idesa\Bancard\Models\Reverse;
use Idesa\Bancard\Requests\Contracts\BancardRequest;

final class QRRevertResponse extends Base\BancardResponse implements Contracts\QRRevertResponse {

    public function __construct(
        BancardRequest $request,
        private ?Reverse $reverse = null,
    ) {
        parent::__construct($request);
    }

    protected static function make(BancardRequest $request, object $data): self {
        return new self(
            request: $request,
            reverse: empty($data->reverse ?? null) ? null : new Reverse($data->reverse),
        );
    }

    public function getReverse(): ?Reverse {
        return $this->reverse;
    }

}
