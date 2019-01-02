<?php

namespace macgyer\yii2spamshield;

use Yii;
use yii\widgets\InputWidget;

/**
 * The input widget class to use in forms.
 *
 * @package macgyer\yii2spamshield
 */
class SpamShield extends InputWidget
{
    /**
     * @var string the template for rendering the input and arithmetical problem
     */
    public $template = '{math} {input}';

    /**
     * @var array the variants for displaying the arithmetical problem
     * Use `{number1}` and `{number2}` as placeholders for the random numbers.
     */
    public $mathSentences = [
        'Please add up {number1} and {number2}.',
        'What is the sum of {number1} and {number2}?',
        '{number1} plus {number2} equals:',
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->generateCalculation();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $input = $this->renderInputHtml('text');

        return strtr($this->template, [
            '{input}' => $input,
            '{math}' => $this->renderMath(),
        ]);
    }

    /**
     * Return the compiled sentence with the arithmetical problem.
     * @return string the sentence
     */
    protected function renderMath()
    {
        $name = self::getSessionKey();
        $randomKey = array_rand($this->mathSentences, 1);
        return strtr($this->mathSentences[$randomKey], [
            '{number1}' => Yii::$app->session->get("$name.number1"),
            '{number2}' => Yii::$app->session->get("$name.number2"),
        ]);
    }

    /**
     * Generate two random integers and store them and their sum in session.
     * @param bool $regenerate whether to regenerate the numbers
     */
    protected function generateCalculation($regenerate = false)
    {
        $name = self::getSessionKey();
        $number1 = mt_rand(1, 20);
        $number2 = mt_rand(1, 20);

        if (!Yii::$app->session->has($name) || $regenerate) {
            Yii::$app->session->set("$name.number1", $number1);
            Yii::$app->session->set("$name.number2", $number2);
            Yii::$app->session->set("$name.result", ($number1 + $number2));
        }
    }

    /**
     * Get the session identifier key.
     * @return string the key
     */
    public static function getSessionKey()
    {
        return '__captcha-spamshield';
    }
}
