<?php declare(strict_types=1);

namespace Idesa\Bancard\Responses\Contracts;

use Idesa\Bancard\Models\QRExpress;

interface QRGenerateResponse {

    public function getQRExpress(): ?QRExpress;

    public function getSupportedClients(): array;

}
