<?php


namespace App\model\core\login;


use League\OAuth2\Client\Provider\Google;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\InvalidLinkException;

/**
 * Class GoogleProviderFactory
 *
 * Factory class for creating a component handling google login
 *
 * @package App\model\core\login
 */
class GoogleProviderFactory
{
    private string $clientId;
    private string $clientSecret;

    private LinkGenerator $linkGenerator;

    /**
     * GoogleProviderFactory constructor.
     *
     * @param string $clientId clientID in OAuth2 protocol
     * @param string $clientSecret client secret in OAuth2 protocol
     * @param LinkGenerator $linkGenerator link generator
     */
    public function __construct(string $clientId, string $clientSecret, LinkGenerator $linkGenerator)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->linkGenerator = $linkGenerator;
    }

    /**
     * @return Google Google provider
     * @throws InvalidLinkException
     */
    public function create(): Google
    {
        return new Google([
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'redirectUri' => $this->linkGenerator->link('Login:in'),
        ]);
    }

}