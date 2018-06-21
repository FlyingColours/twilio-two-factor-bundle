<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle;

use FlyingColours\TwilioTwoFactorBundle\FlyingColoursTwilioTwoFactorBundle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlyingColoursTwilioTwoFactorBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FlyingColoursTwilioTwoFactorBundle::class);
        $this->shouldHaveType(Bundle::class);
    }
}
