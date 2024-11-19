<?php declare(strict_types=1);

namespace Idesa\Bancard\Traits;

use Idesa\Bancard\Services;

trait HasServices {
    use Services\SingleBuy;
    use Services\Cards;
    use Services\Transactions;
    use Services\QR;
}
