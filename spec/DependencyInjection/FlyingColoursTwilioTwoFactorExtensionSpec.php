<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\DependencyInjection;

use FlyingColours\TwilioTwoFactorBundle\DependencyInjection\FlyingColoursTwilioTwoFactorExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class FlyingColoursTwilioTwoFactorExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FlyingColoursTwilioTwoFactorExtension::class);
        $this->shouldHaveType(Extension::class);
    }

    function it_implements_required_load_method(ContainerBuilder $container)
    {
        $container->fileExists(Argument::any())->willReturn(true);
        $container->setDefinition(Argument::any(), Argument::any())->shouldBeCalled();
        $container->setParameter(Argument::any(), Argument::any())->shouldBeCalled();

        $this->load([], $container);
    }
}
