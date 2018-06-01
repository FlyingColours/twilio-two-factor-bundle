<?php

namespace FlyingColours\TwilioTwoFactorBundle\Model\Twilio;

interface TwoFactorInterface
{
    public function isTwilioAuthEnabled(): bool;

    public function getTwilioPreferredMethod(): ?string;

    public function getTwilioPhoneNumber(): ?string ;
}