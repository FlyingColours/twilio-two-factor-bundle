<?php

namespace FlyingColours\TwilioTwoFactorBundle\Model\Twilio;

interface TwoFactorInterface
{
    public function isTwilioAuthEnabled(): bool;
}