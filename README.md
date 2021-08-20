# tokopedia
Library openapi tokopedia

use composer

composer require rusmanab/tokopedia

usage

use Rusmanab\Tokopedia\Client;

$client = new Client(123456);

$product = $client->product->getItems();

