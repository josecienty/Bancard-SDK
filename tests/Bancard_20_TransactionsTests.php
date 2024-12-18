<?php declare(strict_types=1);

namespace Idesa\Bancard\Tests;

use Exception;
use Idesa\Bancard\Bancard;
use Idesa\Bancard\Models\Card;
use Idesa\Bancard\Models\Confirmation;
use Idesa\Bancard\Models\Currency;
use Idesa\Bancard\Requests\ChargeRequest;
use Idesa\Bancard\Responses\Contracts\ChargeResponse;
use Idesa\Bancard\Responses\Contracts\ConfirmationResponse;
use Idesa\Bancard\Responses\Contracts\PreauthorizationConfirmResponse;
use Idesa\Bancard\Responses\Contracts\RollbackResponse;
use Idesa\Bancard\Responses\Contracts\UsersCardsResponse;
use PHPUnit\Framework\TestCase;

final class Bancard_20_TransactionsTests extends TestCase {

    /**
     * @throws Exception
     */
    public function testUserCardsRequest(): Card {
        $this->assertInstanceOf(UsersCardsResponse::class, $response = Bancard::users_cards(
            user_id:    random_int(2**2, 8**8),
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
        $this->assertNotEmpty($cards = $response->getCards());

        return array_shift($cards);
    }

    /**
     * @depends testUserCardsRequest
     *
     * @param  Card  $card
     *
     * @return ChargeRequest
     * @throws Exception
     */
    public function testChargeWithPreAutorizationRequest(Card $card): ChargeRequest {
        $this->assertInstanceOf(ChargeRequest::class, $request = Bancard::newChargeRequest(
            card:            $card,
            shop_process_id: random_int(8**4, 8**8),
            amount:          random_int(5, 20) * 1000,
            currency:        Currency::Guarani,
            description:     'Test',
        ));
        $request->asPreAuthorization();
        $this->assertTrue($request->isPreAuthorization(), 'Failed to enable request pre-authorization mode');
        $this->assertTrue($request->execute(), 'Failed to execute request');
        $this->assertInstanceOf(ChargeResponse::class, $response = $request->getResponse());

        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
        $this->assertInstanceOf(Confirmation::class, $response->getConfirmation());

        return $request;
    }

    /**
     *
     * @param  ChargeRequest  $chargeRequest
     * @depends testChargeWithPreAutorizationRequest
     */
    public function testPreauthorizationConfirmRequest(ChargeRequest $chargeRequest): void {
        $this->assertInstanceOf(PreauthorizationConfirmResponse::class, $response = Bancard::preauthorizationConfirm(
            shop_process_id: $chargeRequest->getShopProcessId(),
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
        $this->assertInstanceOf(Confirmation::class, $response->getConfirmation());
    }

}
