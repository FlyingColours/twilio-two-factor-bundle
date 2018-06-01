<?php

namespace FlyingColours\TwilioTwoFactorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('flying_colours_twilio_two_factor');

        $rootNode
            ->children()
                ->scalarNode('form_template')->defaultValue('@SchebTwoFactor/Authentication/form.html.twig')->end()
                ->arrayNode('twilio')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('username')->defaultNull()->end()
                        ->scalarNode('password')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('config')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('sms_from')->defaultNull()->end()
                        ->scalarNode('sms_message')->defaultValue('%s is your code')->end()
                        ->scalarNode('voice_from')->defaultNull()->end()
                        ->scalarNode('voice_message_url')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
