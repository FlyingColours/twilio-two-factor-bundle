<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\Model\Twilio;

use FlyingColours\TwilioTwoFactorBundle\Model\Twilio\TwoFactorTraitStub;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TwoFactorTraitStubSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TwoFactorTraitStub::class);
    }

    function it_can_be_enabled()
    {
        $this->isTwilioAuthEnabled()->shouldReturn(false);
        $this->setTwilioPhoneNumber('1234')->shouldReturn($this);
        $this->isTwilioAuthEnabled()->shouldReturn(true);
        $this->getTwilioPhoneNumber()->shouldNotReturn(null);
    }

    function it_knows_preferred_method()
    {
        $this->setTwilioPreferredMethod('sms')->shouldReturn($this);
        $this->getTwilioPreferredMethod()->shouldNotReturn(null);
    }
}
