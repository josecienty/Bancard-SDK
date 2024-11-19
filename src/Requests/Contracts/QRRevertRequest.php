<?php declare(strict_types=1);

namespace Idesa\Bancard\Requests\Contracts;

interface QRRevertRequest {

    public function getHookAlias(): string;

}
