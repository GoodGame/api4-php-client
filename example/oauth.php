<?php

require __DIR__ . '/../vendor/autoload.php';

print_r($_GET);

use GoodGame\Oauth2\Factory;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

if (empty($_GET['code'])) {
    die('Что-то пошло не так1');
}

$provider = Factory::getReal(require 'config.php');
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
$refreshToken = $data->getRefreshToken();
?>
<table>
    <tr>
        <td>Access Token</td>
        <td><?= $accessToken ?></td>
    </tr>
    <tr>
        <td>Refresh Token</td>
        <td><?= $refreshToken ?></td>
    </tr>
    <tr>
        <td>Example request</td>
        <td><?php print_r($provider->getUserInfo($accessToken)) ?></td>
    </tr>


    <?php
    $newAccessToken = $provider->getAccessToken('refresh_token', [
        'refresh_token' => $refreshToken,
    ]);
    ?>
    <tr>
        <td>New Access Token</td>
        <td><?= $newAccessToken->getToken() ?></td>
    </tr>
    <tr>
        <td>New Refresh Token</td>
        <td><?= $newAccessToken->getRefreshToken() ?></td>
    </tr>

</table>
