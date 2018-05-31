<?php

namespace FlyingColours\TwilioTwoFactorBundle\Model\Twilio;

interface TwoFactorInterface
{
    public function isTwilioAuthEnabled(): bool;

    public function getTwilioPreferedMethod(): string;

    public function getTwilioPhoneNumber(): string ;
}