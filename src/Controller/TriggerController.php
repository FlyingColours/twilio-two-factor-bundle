<?php

namespace FlyingColours\TwilioTwoFactorBundle\Controller;

use FlyingColours\TwilioTwoFactorBundle\Model\Twilio\TwoFactorInterface;
use Scheb\TwoFactorBundle\Security\Authentication\Token\TwoFactorToken;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class TriggerController
{
    /** @var RouterInterface */
    private $router;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    /** @var EngineInterface */
    private $templating;

    /** @var FormInterface */
    private $form;

    /** @var TwoFactorToken */
    private $token;

    /**
     * TriggerController constructor.
     *
     * @param RouterInterface $router
     * @param EventDispatcherInterface $dispatcher
     * @param EngineInterface $templating
     * @param FormInterface $form
     * @param TwoFactorToken $token
     */
    public function __construct(
        RouterInterface $router,
        EventDispatcherInterface $dispatcher,
        EngineInterface $templating,
        FormInterface $form,
        TwoFactorToken $token
    )
    {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
        $this->templating = $templating;
        $this->form = $form;
        $this->token = $token;
    }

    public function defaultAction(Request $request)
    {
        $this->form->setData($this->token->getUser());

        $this->form->handleRequest($request);

        if ($this->form->isValid())
        {
            /** @var TwoFactorInterface $user */
            $user = $this->form->getData();
            $this->dispatcher->dispatch('twilio.auth.triggered', new GenericEvent($user));

            return new RedirectResponse($this->router->generate('2fa_login'));
        }

        return $this->templating->renderResponse(
            '@FlyingColoursTwilioTwoFactor/trigger/default.html.twig',
            [ 'form' => $this->form->createView() ]
        );
    }
}
