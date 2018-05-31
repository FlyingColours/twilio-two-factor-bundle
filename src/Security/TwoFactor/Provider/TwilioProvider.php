<?php

namespace FlyingColours\TwilioTwoFactorBundle\Security\TwoFactor\Provider;

use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContextInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorFormRendererInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorProviderInterface;
use FlyingColours\TwilioTwoFactorBundle\Model\Twilio;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwilioProvider implements TwoFactorProviderInterface
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /** @var SessionInterface */
    private $session;

    /** @var TwoFactorFormRendererInterface */
    private $renderer;

    /**
     * TwilioProvider constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param SessionInterface $session
     * @param TwoFactorFormRendererInterface $renderer
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        SessionInterface $session,
        TwoFactorFormRendererInterface $renderer
    )
    {
        $this->dispatcher = $dispatcher;
        $this->session = $session;
        $this->renderer = $renderer;
    }

    public function beginAuthentication(AuthenticationContextInterface $context): bool
    {
        $user = $context->getUser();

        if ($user instanceof Twilio\TwoFactorInterface && $user->isTwilioAuthEnabled())
        {
            $this->dispatcher->dispatch('2fa.twilio.start', new GenericEvent($user));

            return true;
        }

        return false;
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
