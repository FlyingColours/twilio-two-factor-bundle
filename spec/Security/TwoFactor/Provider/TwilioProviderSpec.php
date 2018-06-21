<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\Security\TwoFactor\Provider;

use FlyingColours\TwilioTwoFactorBundle\Security\TwoFactor\Provider\TwilioProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContextInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorFormRendererInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorProviderInterface;
use FlyingColours\TwilioTwoFactorBundle\Model\Twilio;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwilioProviderSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher, SessionInterface $session, TwoFactorFormRendererInterface $renderer)
    {
        $this->beConstructedWith($dispatcher, $session, $renderer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TwilioProvider::class);
        $this->shouldHaveType(TwoFactorProviderInterface::class);
    }

    function it_can_trigger_2fa_with_Twilio(AuthenticationContextInterface $context, Twilio\TwoFactorInterface $user, EventDispatcherInterface $dispatcher)
    {
        $this->beginAuthentication($context)->shouldReturn(false);

        $context->getUser()->willReturn($user);
        $user->isTwilioAuthEnabled()->willReturn(false);

        $this->beginAuthentication($context)->shouldReturn(false);

        $user->isTwilioAuthEnabled()->willReturn(true);

        $dispatcher->dispatch(Argument::any(), Argument::any())->shouldBeCalled();

        $this->beginAuthentication($context)->shouldReturn(true);
    }

    function it_can_verify_code(Twilio\TwoFactorInterface $user, SessionInterface $session)
    {
        $session->has('twilio_code')->willReturn(false);
        $this->validateAuthenticationCode($user, $code = '123456')->shouldReturn(false);

        $session->has('twilio_code')->willReturn(true);
        $session->get('twilio_code')->willReturn('654321');

        $this->validateAuthenticationCode($user, $code = '123456')->shouldReturn(false);

        $session->remove('twilio_code')->shouldBeCalled();
        $this->validateAuthenticationCode($user, $code = '654321')->shouldReturn(true);
    }

    function it_returns_renderer(TwoFactorFormRendererInterface $renderer)
    {
        $this->getFormRenderer()->shouldReturn($renderer);
    }
}
