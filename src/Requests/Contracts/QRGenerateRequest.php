<?php declare(strict_types=1);

namespace Idesa\Bancard\Requests\Contracts;

interface QRGenerateRequest extends BancardRequest {

    public function getAmount(): float;

    public function getDescription(): string;

}
