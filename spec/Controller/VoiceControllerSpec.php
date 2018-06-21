<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\Controller;

use FlyingColours\TwilioTwoFactorBundle\Controller\VoiceController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class VoiceControllerSpec extends ObjectBehavior
{
    function let(EngineInterface $templating)
    {
        $this->beConstructedWith($templating);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VoiceController::class);
    }

    function it_has_default_action(EngineInterface $templating)
    {
        $templating->renderResponse(Argument::any())->shouldBeCalled();

        $this->defaultAction();
    }
}
