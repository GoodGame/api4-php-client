<?php

require __DIR__ . '/../vendor/autoload.php';

use GoodGame\Oauth2\Factory;

$provider = Factory::getTest(require 'config.php');
$url = $provider->getAuthorizationUrl();
?>
<a href="<?= $url ?>">На эту ссылку нужно переадресовать вашего пользователя.
    Сейчас вручную перейдите по ссылке
    `<?= $url ?>` и разрешите доступ</a>
