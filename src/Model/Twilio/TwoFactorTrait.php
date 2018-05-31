<?php

namespace FlyingColours\TwilioTwoFactorBundle\Model\Twilio;

trait TwoFactorTrait
{
    /** @var string */
    protected $twilioPhoneNumber;

    /** @var string */
    protected $twilioPreferredMethod;

    public function getTwilioPhoneNumber(): ?string
    {
        return $this->twilioPhoneNumber;
    }

    public function setTwilioPhoneNumber(?string $twilioPhoneNumber)
    {
        $this->twilioPhoneNumber = $twilioPhoneNumber;

        return $this;
    }

    public function getTwilioPreferredMethod(): ?string
    {
        return $this->twilioPreferredMethod;
    }

    public function setTwilioPreferredMethod(?string $twilioPreferredMethod)
    {
        $this->twilioPreferredMethod = $twilioPreferredMethod;

        return $this;
    }

    public function isTwilioAuthEnabled(): bool
    {
        return $this->getTwilioPhoneNumber() !== null;
    }
}