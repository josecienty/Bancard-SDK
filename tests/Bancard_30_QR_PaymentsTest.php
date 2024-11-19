<?php declare(strict_types=1);

namespace Idesa\Bancard\Tests;

use Exception;
use Idesa\Bancard\Bancard;
use Idesa\Bancard\Responses\QRGenerateResponse;
use PHPUnit\Framework\TestCase;

final class Bancard_30_QR_PaymentsTest extends TestCase {

    /**
     * @throws Exception
     */
    public function testQRGenerateRequest(): QRGenerateResponse {
        $this->assertInstanceOf(QRGenerateResponse::class, $response = Bancard::qr_generate(
            amount:      random_int(5, 20) * 1000,
            description: 'QR Payment Test',
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');

        return $response;
    }

    /**
     * @depends testQRGenerateRequest
     * @throws Exception
     */
    public function testQRRevertRequest(QRGenerateResponse $qr_request_response): void {
        $this->assertInstanceOf(QRGenerateResponse::class, $response = Bancard::qr_revert(
            hook_alias: $qr_request_response->getQRExpress()->hook_alias,
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
    }

}
