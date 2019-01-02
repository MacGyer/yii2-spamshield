# Arithmetic Captcha for Yii2

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

You must be able to load NPM assets via Composer. This can either be achieved by the FXP composer asset plugin or by using [Asset Packagist](https://asset-packagist.org/).

To install the package add the following to the ```require``` section of your composer.json:
```
"require": {
    "macgyer/yii2-spamshield": "*"
},
```

## Usage
```php
// in your ActiveForm

<?= $form->field($model, 'yourProperty')->widget(\macgyer\yii2spamshield\SpamShield::class) ?>
```
Please check the source for details on how to configure the widget instance.

```php
// in your Model

public function rules()
{
    return [
        // other rules
        ['yourProperty', \macgyer\yii2spamshield\SpamShieldValidator::class]
    ];
}
```

## Changelog

### 1.0.0 - 2019-01-02
* initial release
