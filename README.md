# Twilio backend (SMS and voice message)

Use Twilio for 2FA (SMS or voice) with Symfony and scheb/two-factor-bundle

[![Version](https://img.shields.io/packagist/v/FlyingColours/twilio-two-factor-bundle.svg?style=flat-square)](https://packagist.org/packages/FlyingColours/twilio-two-factor-bundle)
[![Build Status](https://travis-ci.org/FlyingColours/twilio-two-factor-bundle.svg?branch=develop)](https://travis-ci.org/FlyingColours/twilio-two-factor-bundle)
[![Coverage Status](https://coveralls.io/repos/github/FlyingColours/twilio-two-factor-bundle/badge.svg?branch=develop)](https://coveralls.io/github/FlyingColours/twilio-two-factor-bundle?branch=develop)

## Installation

Step 1: composer

```bash
composer require flyingcolours/twilio-two-factor-bundle
```

Step 2: enable bundle by adding it to AppKernel


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

Step 3: Add interface to your User class (and optionally trait)

```php
<?php
// AppBundle/{Entity,Document}/User.php

use FlyingColours\TwilioTwoFactorBundle\Model\Twilio;

class User implements Twilio\TwoFactorInterface
{
    use Twilio\TwoFactorTrait;
}
```

Step 4: (optionally, if you use trait) update Doctrine mapping

```yaml
# src/AppBundle/Resources/config/doctrine/User.{mongodb,orm}.yml
AppBundle\Document\User:
    fields:
        twilioPhoneNumber:
            type: string
            name: twilio_phone_number
            nullable: true
        twilioPreferredMethod:
            type: string
            name: twilio_preferred_method
            nullable: true
```

And, if you use ORM, update your schema or created and run Doctrine migration

