<?php declare(strict_types=1);

namespace Idesa\Bancard\Tests;

use Exception;
use Idesa\Bancard\Bancard;
use Idesa\Bancard\Requests\CardsNewRequest;
use Idesa\Bancard\Responses\Contracts\CardsNewResponse;
use PHPUnit\Framework\TestCase;

final class Bancard_20_CardsNewTests extends TestCase {

    /**
     * @throws Exception
     */
    public function testCardsNewRequest(): void {
        $this->assertInstanceOf(CardsNewResponse::class, $response = Bancard::card_new(
            user_id:    random_int(2**2, 8**8),
            card_id:    random_int(2**2, 4**4),
            phone_no:   '0981123456',
            email:      'hschimpf@hds-solutions.net',
            return_url: 'https://localhost?success',
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
        $this->assertNotEmpty($response->getProcessId());
    }

    /**
     * @throws Exception
     */
    public function testBuildCustomCardsNewRequest(): CardsNewRequest {
        $request = Bancard::newCardsNewRequest(
            user_id:    random_int(2**2, 8**8),
            card_id:    random_int(2**2, 4**4),
            phone_no:   '0981123456',
            email:      'hschimpf@hds-solutions.net',
        );
        // manually set return URL
        $request->setReturnUrl($return_url = 'https://localhost?success');
        $this->assertSame($request->getReturnUrl(), $return_url);

        return $request;
    }

    /**
     * @depends testBuildCustomCardsNewRequest
     */
    public function testExecuteCardsNewRequest(CardsNewRequest $request): void {
        $this->assertTrue($request->execute());
        $this->assertInstanceOf(CardsNewResponse::class, $response = $request->getResponse());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getProcessId());
    }

}
