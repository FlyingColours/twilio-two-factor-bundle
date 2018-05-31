<?php

namespace FlyingColours\TwilioTwoFactorBundle\EventListener;

use FlyingColours\TwilioTwoFactorBundle\Model\Twilio;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twilio\Rest\Client;

class TwoFaStartSubscriber implements EventSubscriberInterface
{
    /** @var Client */
    private $client;

    /** @var SessionInterface */
    private $session;

    /** @var array */
    private $config;

    /**
     * TwoFaStartSubscriber constructor.
     *
     * @param Client $client
     * @param SessionInterface $session
     * @param array $config
     */
    public function __construct(Client $client, SessionInterface $session, array $config)
    {
        $this->client = $client;
        $this->session = $session;
        $this->config = $config;
    }

    public static function getSubscribedEvents()
    {
        return [ '2fa.twilio.start' => 'onTwoFaTwilioStart' ];
    }

    public function onTwoFaTwilioStart(GenericEvent $event)
    {
        /** @var Twilio\TwoFactorInterface $user */
        $user = $event->getSubject();

        $code = '000000';

        if($user->getTwilioPreferedMethod() == 'sms')
        {
            $this->client->messages->create(
                $user->getTwilioPhoneNumber(), [
                    'from' => $this->config['sms_from'],
                    'body' => sprintf($this->config['sms_message'], $code)
                ]
            );
        }
        else
        {
            // @todo voicemail trigger (@jernej)
        }
    }
}
