<?php

require __DIR__ . '/../vendor/autoload.php';

print_r($_GET);

use GoodGame\Oauth2\Factory;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

if (empty($_GET['code'])) {
    die('Что-то пошло не так1');
}

$provider = Factory::getTest(require 'config.php');
try {
    $data = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);
} catch (IdentityProviderException $exc) {
    echo 'Что-то пошло не так2 ';
    print_r($exc->getMessage() . "\n" . $exc->getTraceAsString());
    die(__FILE__);
}
$accessToken = $data->getToken();
?>
<table>
    <tr>
        <td>Access Token</td>
        <td><?= $accessToken ?></td>
    </tr>
    <tr>
        <td>Refresh Token</td>
        <td><?= $data->getRefreshToken() ?></td>
    </tr>
    <tr>
        <td>Example request</td>
        <td><?php print_r($provider->getUserInfo($accessToken)) ?></td>
    </tr>
</table>
