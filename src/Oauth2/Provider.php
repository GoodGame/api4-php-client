<?php

namespace GoodGame\Oauth2;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

/**
 *
 */
class Provider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public function __construct(
        protected string $host,
        array $options = [],
        array $collaborators = []
    ) {
        parent::__construct($options, $collaborators);
    }

    public function getBaseAuthorizationUrl()
    {
        return $this->host . 'oauth2/authorize';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->host . 'oauth2/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->host . 'oauth2/resource';
    }

    public function getUserInfo($accessToken): array
    {
        $request = $this->getAuthenticatedRequest(
            'GET',
            $this->host . 'api/4/users/@me',
            $accessToken
        );
        $apiResponse = $this->getResponse($request);
        $body = (string)$apiResponse->getBody();
        return json_decode(
            $body,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    protected function getDefaultScopes()
    {
        return [

        ];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            $code = 0;
            $error = $data['error'];

            if (is_array($error)) {
                $code = $error['code'];
                $error = $error['message'];
            }

            throw new IdentityProviderException($error, $code, $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        // TODO: Implement createResourceOwner() method.
//        print_r($response);
        return new User($response);
    }

}
