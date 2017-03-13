<?php
namespace kartik\daterange;

use yii\base\Model;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\base\InvalidConfigException;

/**
 * DateRangeBehavior automatically fills the specified attributes with the parsed date range values.
 *
 * @author Cosmo <daixianceng@gmail.com>
 */
class DateRangeBehavior extends Behavior
{
    /**
     * @var string the attribute that containing date range value.
     */
    public $attribute = 'date_range';

    /**
     * @var string the attribute that will receive date value formatted by `dateFormat`.
     *     Required when `singleDate` set to `true`.
     * @see $dateFormat
     * @see $singleDate
     */
    public $dateAttribute;

    /**
     * @var string the attribute that will receive range start value formatted by `dateStartFormat`.
     *     Required when `singleDate` set to `false`.
     * @see $dateStartFormat
     * @see $singleDate
     */
    public $dateStartAttribute;

    /**
     * @var string the attribute that will receive range end value formatted by `dateEndFormat`.
     *     Required when `singleDate` set to `false`.
     * @see $dateEndFormat
     * @see $singleDate
     */
    public $dateEndAttribute;

    /**
     * @var string|null|false the PHP date format string. It will be used to format the date value.
     *     If set to `null`, this will auto convert the date value into a Unix timestamp.
     *     If set to `false`, there is no formatting action on the date value.
     * @see $dateAttribute
     */
    public $dateFormat;

    /**
     * @var string|null|false the PHP date format string. It will be used to format the range start value.
     *     If set to `null`, this will auto convert the range start value into a Unix timestamp.
     *     If set to `false`, there is no formatting action on the range start value.
     * @see $dateStartAttribute
     */
    public $dateStartFormat;

    /**
     * @var string|null|false the PHP date format string. It will be used to format the range end value.
     *     If set to `null`, this will auto convert the range end value into a Unix timestamp.
     *     If set to `false`, there is no formatting action on the range end value.
     * @see $dateEndAttribute
     */
    public $dateEndFormat;

    /**
     * @var boolean whether the attribute is a single date. Defaults to `false`.
     */
    public $singleDate = false;

    /**
     * @var string the date range separator.
     */
    public $separator;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->singleDate) {
            if ($this->dateAttribute === null) {
                throw new InvalidConfigException('The "dateAttribute" property must be specified.');
            }
        } else {
            if ($this->dateStartAttribute === null || $this->dateEndAttribute === null) {
                throw new InvalidConfigException('The "dateStartAttribute" and "dateEndAttribute" properties must be specified.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Model::EVENT_AFTER_VALIDATE => 'afterValidate',
        ];
    }

    /**
     * Handles owner 'afterValidate' event.
     * @param \yii\base\Event $event event instance.
     */
    public function afterValidate($event)
    {
        if (!$this->owner->hasErrors()) {
            $dateRangeValue = $this->owner->{$this->attribute};
            if (empty($dateRangeValue)) {
                return;
            }
            if ($this->singleDate) {
                $this->setOwnerAttribute($this->dateAttribute, $this->dateFormat, $dateRangeValue);
            } else {
                $separator = empty($this->separator) ? ' - ' : $this->separator;
                $dates = explode($separator, $dateRangeValue, 2);
                if (count($dates) !== 2) {
                    throw new InvalidParamException("There is invalid date range: '{$dateRangeValue}'.");
                }
                $this->setOwnerAttribute($this->dateStartAttribute, $this->dateStartFormat, $dates[0]);
                $this->setOwnerAttribute($this->dateEndAttribute, $this->dateEndFormat, $dates[1]);
            }
        }
    }

    /**
     * Evaluates the attribute value and assigns it to the given attribute.
     * @param string $attribute the owner attribute name
     * @param string $dateFormat the PHP date format string
     * @param string $date a date string
     */
    protected function setOwnerAttribute($attribute, $dateFormat, $date)
    {
        if ($dateFormat === false) {
            $this->owner->$attribute = $date;
        } else {
            $timestamp = static::dateToTime($date);
            if ($dateFormat === null) {
                $this->owner->$attribute = $timestamp;
            } else {
                $this->owner->$attribute = $timestamp !== false ? date($dateFormat, $timestamp) : false;
            }
        }
    }

    /**
     * Parses the given date into a Unix timestamp.
     * @param string $date a date string
     * @return integer|false a Unix timestamp. False on failure.
     */
    protected static function dateToTime($date)
    {
        return strtotime($date);
    }
}
