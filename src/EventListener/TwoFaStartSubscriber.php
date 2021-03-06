<?php

namespace FlyingColours\TwilioTwoFactorBundle\EventListener;

use FlyingColours\TwilioTwoFactorBundle\Model\Twilio;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
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

    /** @var string */
    private $host;

    /**
     * TwoFaStartSubscriber constructor.
     *
     * @param Client $client
     * @param SessionInterface $session
     * @param array $config
     * @param Request $request
     */
    public function __construct(Client $client, SessionInterface $session, array $config, ?Request $request = null)
    {
        $this->client = $client;
        $this->session = $session;
        $this->config = $config;

        if($request) $this->host = $request->getHost();
    }

    public static function getSubscribedEvents()
    {
        return [ 'twilio.auth.triggered' => 'onTwilioAuthTriggered' ];
    }

    public function onTwilioAuthTriggered(GenericEvent $event)
    {
        /** @var Twilio\TwoFactorInterface $user */
        $user = $event->getSubject();

        $min = pow(10, 6 - 1);
        $max = pow(10, 6) - 1;
        $code = random_int($min, $max);

        $this->session->set('twilio_code', (string) $code);

        if($user->getTwilioPreferredMethod() == 'sms')
        {
            $this->client->messages->create(
                $user->getTwilioPhoneNumber(), [
                    'from' => $this->config['sms_from'],
                    'body' => preg_replace('/{code}/', $code, $this->config['sms_message'])
                ]
            );
        }
        else
        {
            if ( ! $this->config['voice_message_url'] && $this->host)
            {
                $this->config['voice_message_url'] = sprintf('http://%s/voice-ctrl?code={code}', $this->host);
            }

            $this->client->account->calls->create(
                $user->getTwilioPhoneNumber(),
                $this->config['voice_from'],
                [ 'url' => preg_replace('/{code}/', $code, $this->config['voice_message_url']) ]
            );
        }
    }
}
