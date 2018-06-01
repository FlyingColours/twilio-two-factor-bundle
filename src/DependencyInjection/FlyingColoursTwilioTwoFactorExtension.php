<?php

namespace FlyingColours\TwilioTwoFactorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class FlyingColoursTwilioTwoFactorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        foreach($config as $l1 => $val1)
        {
            if(is_array($val1))
            {
                foreach ($val1 as $l2 => $val2)
                {
                    $container->setParameter(sprintf('flying_colours_twilio_two_factor.%s.%s', $l1, $l2), $val2);
                }
            }
            else
            {
                $container->setParameter(sprintf('flying_colours_twilio_two_factor.%s', $l1), $val1);
            }

        }

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yml');


    }
}
