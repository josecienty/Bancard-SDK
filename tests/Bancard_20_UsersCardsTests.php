<?php declare(strict_types=1);

namespace Idesa\Bancard\Tests;

use Exception;
use Idesa\Bancard\Bancard;
use Idesa\Bancard\Models\Card;
use Idesa\Bancard\Models\Confirmation;
use Idesa\Bancard\Models\Currency;
use Idesa\Bancard\Requests\ChargeRequest;
use Idesa\Bancard\Responses\CardDeleteResponse;
use Idesa\Bancard\Responses\Contracts\ConfirmationResponse;
use Idesa\Bancard\Responses\Contracts\RollbackResponse;
use Idesa\Bancard\Responses\Contracts\UsersCardsResponse;
use Idesa\Bancard\Responses\Contracts\ChargeResponse;
use PHPUnit\Framework\TestCase;

final class Bancard_20_UsersCardsTests extends TestCase {

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
    public function testChargeRequest(Card $card): ChargeRequest {
        $this->assertInstanceOf(ChargeResponse::class, $response = Bancard::charge(
            card:            $card,
            shop_process_id: random_int(8**4, 8**8),
            amount:          random_int(5, 20) * 1000,
            currency:        Currency::Guarani,
            description:     'Test',
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
        $this->assertInstanceOf(Confirmation::class, $response->getConfirmation());

        return $response->getRequest();
    }

    /**
     * @depends testChargeRequest
     *
     * @param  ChargeRequest  $chargeRequest
     */
    public function testConfirmationRequest(ChargeRequest $chargeRequest): void {
        $this->assertInstanceOf(ConfirmationResponse::class, $response = Bancard::confirmation(
            shop_process_id: $chargeRequest->getShopProcessId(),
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
        $this->assertInstanceOf(Confirmation::class, $response->getConfirmation());
    }

    /**
     * @param  ChargeRequest  $chargeRequest
     *
     * @return void
     * @depends testChargeRequest
     */
    public function testRollbackRequest(ChargeRequest $chargeRequest): void {
        $this->assertInstanceOf(RollbackResponse::class, $response = Bancard::rollback(
            shop_process_id: $chargeRequest->getShopProcessId(),
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
    }

    /**
     * @param  Card  $card
     *
     * @return void
     * @depends testUserCardsRequest
     */
    public function testCardDeleteRequest(Card $card): void {
        $this->assertInstanceOf(CardDeleteResponse::class, $response = Bancard::card_delete(
            card: $card,
        ));
        $this->assertTrue($response->wasSuccess(), $response->getMessages()[0]->description ?? 'Unknown');
    }

}
