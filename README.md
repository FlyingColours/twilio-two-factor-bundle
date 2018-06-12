# Twilio backend (SMS and voice message)

Use Twilio for 2FA (SMS or voice) with Symfony and scheb/two-factor-bundle

[![Version](https://img.shields.io/packagist/v/FlyingColours/twilio-two-factor-bundle.svg?style=flat-square)](https://packagist.org/packages/FlyingColours/twilio-two-factor-bundle)
[![Build Status](https://travis-ci.org/FlyingColours/twilio-two-factor-bundle.svg?branch=develop)](https://travis-ci.org/FlyingColours/twilio-two-factor-bundle)
[![Coverage Status](https://coveralls.io/repos/github/FlyingColours/twilio-two-factor-bundle/badge.svg?branch=develop)](https://coveralls.io/github/FlyingColours/twilio-two-factor-bundle?branch=develop)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FlyingColours/twilio-two-factor-bundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/FlyingColours/twilio-two-factor-bundle/?branch=develop)
[![License](https://poser.pugx.org/FlyingColours/twilio-two-factor-bundle/license.svg)](https://packagist.org/packages/FlyingColours/twilio-two-factor-bundle)


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
// src/AppBundle/{Entity,Document}/User.php

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

And, if you use ORM, update your schema or create and run Doctrine migration

## Configuration

Step 1: configure bundle in config.yml

```yaml
# app/config/config.yml

flying_colours_twilio_two_factor:
    form_template: '@SchebTwoFactor/Authentication/form.html.twig'
    twilio:
        username: ~ # [required] aka SID
        password: ~ # [required] aka token
    config:
        sms_from: ~ # [required] this shows on the SMS sender field (it does not have to be a phone number)
        sms_message: "{code} is your code"
        voice_from: ~ # [required] this has to be phone number
        voice_message_url: ~ # voice controller URL, must be accessible from web. Leave empty for default, otherwise add "{code}" for code
```

Step 2: add routing to provide URL for voice controller

```yaml
# app/config/routing.yml

twilio_voice:
    resource: "@FlyingColoursTwilioTwoFactorBundle/Resources/config/routing.yml"
```

Step 3: Make sure voice controller is publicly accessible (for Twilio)

```yaml
# app/config/security.yml

security:
    access_control:
        - { path: ^/voice-ctrl$, role: IS_AUTHENTICATED_ANONYMOUSLY }
```

Now your voice controller should be accessible at [http://you.project.url/voice-ctrl?code=123456](http://you.project.url/voice-ctrl?code=123456)

Step 4: Customise your voice message by overriding the twig template

```bash
mkdir -p app/Resources/FlyingColoursTwilioTwoFactorBundle/views/voice && \
cp ./vendor/flyingcolours/twilio-two-factor-bundle/src/Resources/views/voice/default.xml.twig \
./app/Resources/FlyingColoursTwilioTwoFactorBundle/views/voice/
```

## Development notes

When you develop your app locally (i.e. using Vagrant), it's very likely that your local instance 
is not publicly available. In order to use voice authentication, you can use one of the Twilio twimlets,
called "echo" like this:

```yaml
# app/config/config_dev.yml

flying_colours_twilio_two_factor:
    config:
        voice_message_url: "http://twimlets.com/echo?Twiml=%%3CResponse%%3E%%3CSay%%3EYour+code+is+{code}%%3C%%2FSay%%3E%%3C%%2FResponse%%3E"
```
