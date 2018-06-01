<?php

namespace FlyingColours\TwilioTwoFactorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class VoiceController
{
    /** @var EngineInterface */
    private $templating;

    /**
     * VoiceController constructor.
     *
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function defaultAction()
    {
        return $this->templating->renderResponse('@FlyingColoursTwilioTwoFactor/voice/default.xml.twig');
    }
}