<?php

require __DIR__ . '/../vendor/autoload.php';

use GoodGame\Oauth2\Factory;

//$provider = Factory::getTest(require 'config.php');
$provider = Factory::getReal(require 'config.php');
$url = $provider->getAuthorizationUrl([
    'approval_prompt' => 'auto', // 'force',
]);
?>
<a href="<?= $url ?>">На эту ссылку нужно переадресовать вашего пользователя.
    Сейчас вручную перейдите по ссылке
    `<?= $url ?>` и разрешите доступ</a>
