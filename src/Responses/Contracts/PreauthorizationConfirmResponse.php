<?php declare(strict_types=1);

namespace Idesa\Bancard\Responses\Contracts;

use Idesa\Bancard\Models\Confirmation;

interface PreauthorizationConfirmResponse {

    public function getConfirmation(): ?Confirmation;

}
