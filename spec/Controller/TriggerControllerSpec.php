<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\Controller;

use FlyingColours\TwilioTwoFactorBundle\Controller\TriggerController;
use FlyingColours\TwilioTwoFactorBundle\Model\Twilio\TwoFactorInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scheb\TwoFactorBundle\Security\Authentication\Token\TwoFactorToken;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class TriggerControllerSpec extends ObjectBehavior
{
    function let(
        RouterInterface $router,
        EventDispatcherInterface $dispatcher,
        EngineInterface $templating,
        FormInterface $form,
        TwoFactorToken $token
    )
    {
        $this->beConstructedWith($router, $dispatcher, $templating, $form, $token);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TriggerController::class);
    }

    function it_has_a_defaultAction(
        Request $request,
        FormInterface $form,
        EngineInterface $templating,
        TwoFactorToken $token,
        TwoFactorInterface $user,
        EventDispatcherInterface $dispatcher,
        RouterInterface $router,
        GenericEvent $event
    )
    {
        $token->getUser()->willReturn($user);

        $form->setData(Argument::any())->shouldBeCalled();
        $form->handleRequest($request)->shouldBeCalled();
        $form->createView()->shouldBeCalled();
        $form->isValid()->willReturn(false);

        $templating->renderResponse(Argument::any(), Argument::any())->willReturn('not null');

        $this->defaultAction($request)->shouldNotReturn(null);

        $form->isValid()->willReturn(true);
        $form->getData()->willReturn($user);

        $dispatcher->dispatch(Argument::any(), Argument::any())->willReturn($event);

        $event->hasArgument('route')->willReturn(false);

        $router->generate(Argument::any())->willReturn('/some/url');

        $this->defaultAction($request)->shouldNotReturn(null);

        $event->hasArgument('route')->willReturn(true);
        $event->getArgument('route')->willReturn('something');

        $this->defaultAction($request)->shouldNotReturn(null);
    }
}
