# api4-php-client

Смотрите пример в папке example

# Памятка

## Регистрация приложения

https://goodgame.ru/user/ВашИдентификатор/oauth2

Для регистрации Вы должны придумать уникальный client_id и ссылку redirect_uri, которая ведет на Ваш сайт/домен.

После регистрации Вы получите client_secret, который надо хранить в секрете.

## Ссылка, на которую надо перенаправить пользователя

```
https://goodgame.ru/oauth2/authorize?state={STATE}&scope=&response_type=code&approval_prompt=auto&redirect_uri=https://...&client_id=MyClient
```

Где redirect_uri и client_id Вы ввели на предыдущем шаге.

## Пользователь разрешил доступ к Вашему приложению

Если пользовать разрешил данные, то GoodGame переадресует пользователя на redirect_uri, указанный при регистрации и в
GET параметре code подставит код авторизации, на основе которого можно получить AccessToken и RefreshToken.

Пример:

```
https://your-domain/?code=def50200a...71f9f9e21&state={STATE}
```

## Пользователь запретил доступ к Вашему приложению

Если пользовать не дал разрешения, то GoodGame переадресует пользователя на redirect_uri, указанный при регистрации и в GET
параметре error указывает ошибку 'access_denied' и в error_description 'The user clicked deny'.

Пример:

```
https://your-domain/?error=access_denied&state={STATE}&error_description=The user clicked deny
```

## Получение AccessToken и RefreshToken

```
POST https://goodgame.ru/oauth2/token
Content-Type: application/x-www-form-urlencoded

grant_type: authorization_code
client_id: MyClient
client_secret: OtQ:MRWc9...FNuhBHP
redirect_uri: https://your-domain
code: def50200a...71f9f9e21
```

Ответ будет следующим:

```
{
    "token_type": "Bearer",
    "expires_in": 3600,
    "access_token": "eyJ0eXAi...Dw7g7g",
    "refresh_token": "de1...1d13"
}
```

## Использование AccessToken

Путь 'users/@me' использован для примера.

Можно посылать токен в заголовке Authorization: Bearer

```
GET https://goodgame.ru/api/4/users/@me
Authorization: Bearer eyJ0eXAi...Dw7g7g
```

ИЛИ

В GET/POST-параметре access_token

```
GET https://test.goodgame.ru/api/4/user/?access_token=eyJ0eXAi...Dw7g7g
```

## Использование RefreshToken

```
POST https://goodgame.ru/oauth2/token
Content-Type: application/x-www-form-urlencoded

grant_type: refresh_token
refresh_token: def1...1bd13
client_id: MyClient
client_secret: OtQ:MRWc9...FNuhBHP
redirect_uri: https://your-domain
```

В ответе будут новые данные:

```
{
    "token_type": "Bearer",
    "expires_in": 3600,
    "access_token": "eyJ0eXAiOiJK...3XPhcag",
    "refresh_token": "def50200f659...845dc279fceee"
}
```
