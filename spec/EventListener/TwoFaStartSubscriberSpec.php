<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\EventListener;

use FlyingColours\TwilioTwoFactorBundle\EventListener\TwoFaStartSubscriber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twilio\Rest\Api\V2010\Account\MessageList;
use Twilio\Rest\Client;
use FlyingColours\TwilioTwoFactorBundle\Model\Twilio;

class TwoFaStartSubscriberSpec extends ObjectBehavior
{
    function let(Client $client, SessionInterface $session, MessageList $messageList)
    {
        $this->beConstructedWith($client, $session, $config = [ 'sms_from' => 'some phone number', 'sms_message' => '%s is your code']);
        $client->messages = $messageList;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TwoFaStartSubscriber::class);
        $this->shouldHaveType(EventSubscriberInterface::class);
    }

    function it_implements_required_method()
    {
        $this->getSubscribedEvents()->shouldHaveCount(1);
    }

    function it_contacts_twilio_to_send_SMS_or_trigger_voice_message(GenericEvent $event, Twilio\TwoFactorInterface $user, MessageList $messageList)
    {
        $event->getSubject()->willReturn($user);

        $user->getTwilioPreferredMethod()->willReturn('sms');
        $user->getTwilioPhoneNumber()->shouldBeCalled();

        $messageList->create(Argument::any(), Argument::any())->shouldBeCalled();

        $this->onTwoFaTwilioStart($event);
    }
}
