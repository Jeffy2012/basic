<?php

namespace app\validators;


use Yii;
use yii\validators\Validator;
use yii\validators\ValidationAsset;
use yii\web\JsExpression;
use yii\helpers\Json;

/**
 * BooleanValidator checks if the attribute value is a boolean value.
 *
 * Possible boolean values can be configured via the [[trueValue]] and [[falseValue]] properties.
 * And the comparison can be either [[strict]] or not.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PhoneValidator extends Validator
{
    public $pattern = '/^1\d{10}$/i';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} not".');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $valid = preg_match($this->pattern, $value);

        if (!$valid) {
            return [$this->message, []];
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
//    public function clientValidateAttribute($object, $attribute, $view)
//    {
//        $options = [
//            'pattern' => new JsExpression($this->pattern),
//            'message' => Yii::$app->getI18n()->format($this->message, [
//                    'attribute' => $object->getAttributeLabel($attribute)
//                ], Yii::$app->language),
//        ];
//        if ($this->skipOnEmpty) {
//            $options['skipOnEmpty'] = 1;
//        }
//        if ($this->strict) {
//            $options['strict'] = 1;
//        }
//
//        ValidationAsset::register($view);
//
//        return 'yii.validation.phone(value, messages, ' . Json::encode($options) . ');';
//    }
}
