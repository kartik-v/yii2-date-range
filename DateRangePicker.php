<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2016
 * @package yii2-date-range
 * @version 1.6.6
 */

namespace kartik\daterange;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\base\InputWidget;

/**
 * An advanced date range picker input for Yii Framework 2 based on bootstrap-daterangepicker plugin.
 *
 * @see https://github.com/dangrossman/bootstrap-daterangepicker
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DateRangePicker extends InputWidget
{
    /**
     * @var string the javascript callback to be passed to the plugin constructor. Note: a default value is set for
     * this property when you set `hideInput` to false, OR you set `useWithAddon` to `true` or `autoUpdateOnInit` to
     * `false`. If you set a value here it will override any auto-generated callbacks.
     */
    public $callback = null;

    /**
     * @var boolean whether to auto update the input on initialization. If set to `false`, this will auto set the
     * plugin's `autoUpdateInput` to `false`. A default `callback` will be auto-generated when this is set to `false`.
     */
    public $autoUpdateOnInit = false;

    /**
     * @var boolean whether to hide the input (e.g. when you want to show the date range picker as a dropdown). If set
     * to `true`, the input will be hidden. The plugin will be initialized on a container element (default 'div'),
     * using the container template. A default `callback` will be setup in this case to display the selected range
     * value within the container.
     */
    public $hideInput = false;

    /**
     * @var boolean whether you are using the picker with a input group addon. You can set it to `true`, when
     * `hideInput` is false, and you wish to show the picker position more correctly at the input-group-addon icon.
     * A default `callback` will be generated in this case to generate the selected range value for the input.
     */
    public $useWithAddon = false;

    /**
     * @var boolean initialize all the list values set in `pluginOptions['ranges']` and convert all values to
     * `yii\web\JsExpression`
     */
    public $initRangeExpr = true;

    /**
     * @var boolean show a preset dropdown. If set to true, this will automatically generate a preset list of ranges
     * for selection. Setting this to true will also automatically set `initRangeExpr` to true.
     */
    public $presetDropdown = false;

    /**
     * @var array the HTML attributes for the container, if hideInput is set to true. The following special options
     * are recognized:
     * - `tag`: string, the HTML tag for rendering the container. Defaults to `div`.
     */
    public $containerOptions = ['class' => 'drp-container input-group'];

    /**
     * @var array the template for rendering the container, when hideInput is set to `true`. The special tag `{input}`
     * will be replaced with the hidden form input. In addition, the element with css class `range-value` will be
     * replaced by the calculated plugin value. The special tag `{value}` will be replaced with the value of the hidden
     * form input during initialization
     */
    public $containerTemplate = <<< HTML
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
        <span class="form-control text-right">
            <span class="pull-left">
                <span class="range-value">{value}</span>
            </span>
            <b class="caret"></b>
            {input}
        </span>
HTML;

    /**
     * @var array the HTML attributes for the form input
     */
    public $options = ['class' => 'form-control'];

    /**
     * @inheritdoc
     */
    public $pluginName = 'daterangepicker';

    /**
     * @var string locale language to be used for the plugin
     */
    protected $_localeLang = '';

    /**
     * @var string the pluginOptions format for the date time
     */
    protected $_format;

    /**
     * @var string the pluginOptions separator
     */
    protected $_separator;

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->_msgCat = 'kvdrp';
        $this->initI18N(__DIR__);
        $this->initLocale();
        if ($this->convertFormat && isset($this->pluginOptions['locale']) && isset($this->pluginOptions['locale']['format'])) {
            $this->pluginOptions['locale']['format'] = static::convertDateFormat($this->pluginOptions['locale']['format']);
        }
        $locale = ArrayHelper::getValue($this->pluginOptions, 'locale', []);
        $this->_format = ArrayHelper::getValue($locale, 'format', 'YYYY-MM-DD');
        $this->_separator = ArrayHelper::getValue($locale, 'separator', ' - ');
        if (!empty($this->value)) {
            $dates = explode($this->_separator, $this->value);
            if (count($dates) > 1) {
                $this->pluginOptions['startDate'] = $dates[0];
                $this->pluginOptions['endDate'] = $dates[1];
            }
        }
        $value = empty($this->value) ? '' : $this->value;
        $this->containerTemplate = str_replace('{value}', $value, $this->containerTemplate);

        // Set `autoUpdateInput` to false for certain settings
        if (!$this->autoUpdateOnInit || $this->hideInput || $this->useWithAddon) {
            $this->pluginOptions['autoUpdateInput'] = false;
        }

        $this->initRange();
        $this->containerOptions['id'] = $this->options['id'] . '-container';
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Initialize locale settings
     */
    protected function initLocale()
    {
        $this->setLanguage('');
        if (empty($this->_langFile)) {
            return;
        }
        $localeSettings = ArrayHelper::getValue($this->pluginOptions, 'locale', []);
        $localeSettings += [
            'applyLabel' => Yii::t('kvdrp', 'Apply'),
            'cancelLabel' => Yii::t('kvdrp', 'Cancel'),
            'fromLabel' => Yii::t('kvdrp', 'From'),
            'toLabel' => Yii::t('kvdrp', 'To'),
            'weekLabel' => Yii::t('kvdrp', 'W'),
            'customRangeLabel' => Yii::t('kvdrp', 'Custom Range'),
            'daysOfWeek' => new JsExpression('moment.weekdaysMin()'),
            'monthNames' => new JsExpression('moment.monthsShort()'),
            'firstDay' => new JsExpression('moment.localeData()._week.dow')
        ];
        $this->pluginOptions['locale'] = $localeSettings;
    }

    /**
     * Automatically convert the date format from PHP DateTime to Moment.js DateTime format as required by
     * the `bootstrap-daterangepicker` plugin.
     *
     * @see http://php.net/manual/en/function.date.php
     * @see http://momentjs.com/docs/#/parsing/string-format/
     *
     * @param string $format the PHP date format string
     *
     * @return string
     */
    protected static function convertDateFormat($format)
    {
        return strtr($format, [
            // meridian lowercase remains same
            // 'a' => 'a',
            // meridian uppercase remains same
            // 'A' => 'A',
            // second (with leading zeros)
            's' => 'ss',
            // minute (with leading zeros)
            'i' => 'mm',
            // hour in 12-hour format (no leading zeros)
            'g' => 'h',
            // hour in 12-hour format (with leading zeros)
            'h' => 'hh',
            // hour in 24-hour format (no leading zeros)
            'G' => 'H',
            // hour in 24-hour format (with leading zeros)
            'H' => 'HH',
            //  day of the week locale
            'w' => 'e',
            //  day of the week ISO
            'W' => 'E',
            // day of month (no leading zero)
            'j' => 'D',
            // day of month (two digit)
            'd' => 'DD',
            // day name short
            'D' => 'DDD',
            // day name long
            'l' => 'DDDD',
            // month of year (no leading zero)
            'n' => 'M',
            // month of year (two digit)
            'm' => 'MM',
            // month name short
            'M' => 'MMM',
            // month name long
            'F' => 'MMMM',
            // year (two digit)
            'y' => 'YY',
            // year (four digit)
            'Y' => 'YYYY',
            // unix timestamp
            'U' => 'X',
        ]);
    }

    /**
     * Initializes the pluginOptions range list
     */
    protected function initRange()
    {
        if (isset($dummyValidation)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $msg = Yii::t('kvdrp', 'Select Date Range');
        }
        if ($this->presetDropdown) {
            $this->initRangeExpr = true;
            $this->pluginOptions['ranges'] = [
                Yii::t('kvdrp', "Today") => ["moment().startOf('day')", "moment()"],
                Yii::t('kvdrp', "Yesterday") => [
                    "moment().startOf('day').subtract(1,'days')",
                    "moment().endOf('day').subtract(1,'days')"
                ],
                Yii::t('kvdrp', "Last {n} Days", ['n' => 7]) => [
                    "moment().startOf('day').subtract(6, 'days')",
                    "moment()"
                ],
                Yii::t('kvdrp', "Last {n} Days", ['n' => 30]) => [
                    "moment().startOf('day').subtract(29, 'days')",
                    "moment()"
                ],
                Yii::t('kvdrp', "This Month") => ["moment().startOf('month')", "moment().endOf('month')"],
                Yii::t('kvdrp', "Last Month") => [
                    "moment().subtract(1, 'month').startOf('month')",
                    "moment().subtract(1, 'month').endOf('month')"
                ],
            ];
        }
        if (!$this->initRangeExpr || empty($this->pluginOptions['ranges']) || !is_array($this->pluginOptions['ranges'])) {
            return;
        }
        $range = [];
        foreach ($this->pluginOptions['ranges'] as $key => $value) {
            if (!is_array($value) || empty($value[0]) || empty($value[1])) {
                throw new InvalidConfigException("Invalid settings for pluginOptions['ranges']. Each range value must be a two element array.");
            }
            $range[$key] = [static::parseJsExpr($value[0]), static::parseJsExpr($value[1])];
        }
        $this->pluginOptions['ranges'] = $range;
    }

    /**
     * Parses and returns a JsExpression
     *
     * @param string|JsExpression $value
     *
     * @return JsExpression
     */
    protected static function parseJsExpr($value)
    {
        return $value instanceof JsExpression ? $value : new JsExpression($value);
    }

    /**
     * Registers the needed client assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        MomentAsset::register($view);
        $input = 'jQuery("#' . $this->options['id'] . '")';
        $id = $input;
        if ($this->hideInput) {
            $id = 'jQuery("#' . $this->containerOptions['id'] . '")';
        }
        if (!empty($this->_langFile)) {
            LanguageAsset::register($view)->js[] = $this->_langFile;
        }
        DateRangePickerAsset::register($view);
        if (empty($this->callback)) {
            $val = "start.format('{$this->_format}') + '{$this->_separator}' + end.format('{$this->_format}')";
            if (ArrayHelper::getValue($this->pluginOptions, 'singleDatePicker', false)) {
                $val = "start.format('{$this->_format}')";
            }
            $change = "{$input}.val(val);{$input}.trigger('change');";
            if ($this->hideInput) {
                $script = "var val={$val};{$id}.find('.range-value').html(val);{$change}";
            } elseif ($this->useWithAddon) {
                $id = "{$input}.closest('.input-group')";
                $script = "var val={$val};{$change}";
            } elseif (!$this->autoUpdateOnInit) {
                $script = "var val={$val};{$change}";
            } else {
                $this->registerPlugin($this->pluginName, $id);
                return;
            }
            $this->callback = "function(start,end,label){{$script}}";
        }
        $this->registerPlugin($this->pluginName, $id, null, $this->callback);
    }

    /**
     * Renders the input
     *
     * @return string
     */
    protected function renderInput()
    {
        if (!$this->hideInput) {
            return $this->getInput('textInput');
        }
        $tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
        $content = str_replace('{input}', $this->getInput('hiddenInput'), $this->containerTemplate);
        return Html::tag($tag, $content, $this->containerOptions);
    }
}
