<?php

namespace spec\FlyingColours\TwilioTwoFactorBundle\Form;

use FlyingColours\TwilioTwoFactorBundle\Form\TriggerFormType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TriggerFormTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TriggerFormType::class);
        $this->shouldHaveType(AbstractType::class);
    }

    function it_implements_configureOptions_method(OptionsResolver $resolver)
    {
        $resolver->setDefaults(Argument::any())->shouldBeCalled();

        $this->configureOptions($resolver);
    }

    function it_implements_buildForm_method(FormBuilderInterface $builder)
    {
        $builder->add(Argument::any(), Argument::any(), Argument::any())->willReturn($builder);

        $this->buildForm($builder, []);
    }
}
