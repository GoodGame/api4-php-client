<?php

namespace GoodGame\Oauth2;

class Factory
{
    public static function getTest(array $config): Provider
    {
        return new Provider('https://test.goodgame.ru/', $config);
    }
}
