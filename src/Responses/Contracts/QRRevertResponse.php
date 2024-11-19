<?php declare(strict_types=1);

namespace Idesa\Bancard\Responses\Contracts;

use Idesa\Bancard\Models\Reverse;

interface QRRevertResponse {

    public function getReverse(): ?Reverse;

}
