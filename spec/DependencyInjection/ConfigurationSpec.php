<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\DependencyInjection;

use FlyingColours\TwilioTwoFactorBundle\DependencyInjection\Configuration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Configuration::class);
        $this->shouldHaveType(ConfigurationInterface::class);
    }

    function it_created_config_tree()
    {
        $this->getConfigTreeBuilder()->shouldNotReturn(null);
    }
}
