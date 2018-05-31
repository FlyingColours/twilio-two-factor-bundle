# Twilio backend (SMS and voice message)

Use Twilio for 2FA (SMS or voice) with Symfony and scheb/two-factor-bundle

[![Version](https://img.shields.io/packagist/v/FlyingColours/twilio-two-factor-bundle.svg?style=flat-square)](https://packagist.org/packages/FlyingColours/twilio-two-factor-bundle)
[![Build Status](https://travis-ci.org/FlyingColours/twilio-two-factor-bundle.svg?branch=develop)](https://travis-ci.org/FlyingColours/twilio-two-factor-bundle)
[![Coverage Status](https://coveralls.io/repos/github/FlyingColours/twilio-two-factor-bundle/badge.svg?branch=develop)](https://coveralls.io/github/FlyingColours/twilio-two-factor-bundle?branch=develop)

## Installation

```bash
composer require flyingcolours/twilio-two-factor-bundle
```

Add bundle to AppKernel

```php
<?php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Scheb\TwoFactorBundle\SchebTwoFactorBundle(),
            new FlyingColours\TwilioTwoFactorBundle\FlyingColoursTwilioTwoFactorBundle(),
            // ...    
        ];
    }
}

```