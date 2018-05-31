<?php

namespace FlyingColours\TwilioTwoFactorBundle\Security\TwoFactor\Provider;

use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContextInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorFormRendererInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorProviderInterface;
use FlyingColours\TwilioTwoFactorBundle\Model\Twilio;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwilioProvider implements TwoFactorProviderInterface
{
    /** @var SessionInterface */
    private $session;

    /** @var TwoFactorFormRendererInterface */
    private $renderer;

    /**
     * TwilioProvider constructor.
     *
     * @param SessionInterface $session
     * @param TwoFactorFormRendererInterface $renderer
     */
    public function __construct(SessionInterface $session, TwoFactorFormRendererInterface $renderer)
    {
        $this->session = $session;
        $this->renderer = $renderer;
    }

    public function beginAuthentication(AuthenticationContextInterface $context): bool
    {
        $user = $context->getUser();

        return $user instanceof Twilio\TwoFactorInterface && $user->isTwilioAuthEnabled();
    }

    public function validateAuthenticationCode($user, string $authenticationCode): bool
    {
        if ( ! $user instanceof Twilio\TwoFactorInterface || ! $this->session->has('twilio_code'))
        {
            return false;
        }

        return hash_equals($this->session->get('twilio_code'), $authenticationCode);
    }

    public function getFormRenderer(): TwoFactorFormRendererInterface
    {
        return $this->renderer;
    }
}
