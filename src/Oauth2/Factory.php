<?php

namespace GoodGame\Oauth2;

class Factory
{
    /**
     * Это отдельный тестовый домен, где можно проверить свое приложение не в условиях прода
     * @param array $config
     * @return Provider
     */
    public static function getTest(array $config): Provider
    {
        return new Provider('https://test.goodgame.ru/', $config);
    }

    /**
     * Уже прод, тут настоящие пользователи
     * @param array $config
     * @return Provider
     */
    public static function getReal(array $config): Provider
    {
        return new Provider('https://goodgame.ru/', $config);
    }
}
