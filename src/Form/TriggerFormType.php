<?php

namespace FlyingColours\TwilioTwoFactorBundle\Form;

use FlyingColours\TwilioTwoFactorBundle\Model\Twilio\TwoFactorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TriggerFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'name' => 'trigger',
            'data_class' => TwoFactorInterface::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $methods = [ 'sms', 'call' ];

        $builder
            ->add('twilioPreferredMethod', ChoiceType::class, [
                'label' => 'Preferred contact method',
                'choices' => array_combine($methods, $methods)
            ])
            ->add('send', SubmitType::class)
        ;
    }
}
