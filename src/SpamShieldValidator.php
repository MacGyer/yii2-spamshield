<?php

namespace macgyer\yii2spamshield;

use Yii;
use yii\validators\Validator;

/**
 * Class SpamShieldValidator
 * @package macgyer\yii2spamshield
 */
class SpamShieldValidator extends Validator
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'The math result is incorrect.';
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function validateValue($value)
    {
        $name = SpamShield::getSessionKey();
        $valid = (int)$value === Yii::$app->session->get("$name.result");

        return $valid ? null : [$this->message, []];
    }
}
