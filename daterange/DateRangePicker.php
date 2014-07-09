<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-date-range
 * @version 1.0.0
 */

namespace kartik\daterange;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\web\View;

/**
 * An advanced date range picker input for Yii Framework 2 based on
 * bootstrap-daterangepicker plugin.
 *
 * @see https://github.com/dangrossman/bootstrap-daterangepicker
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DateRangePicker extends \kartik\widgets\InputWidget
{
    const PLUGIN_NAME = 'daterangepicker';

    /**
     * @var string the javascript callback to be passed to the plugin constructor.
     * Note: a default value is set for this when you set `hideInput` to false, OR
     * you set `useWithAddon` to `true`.
     * @see https://github.com/dangrossman/bootstrap-daterangepicker#options
     */
    public $callback;

    /**
     * @var boolean whether to hide the input (e.g. when you want to show the date
     * range picker as a dropdown). If set to true, the input will be hidden. The plugin
     * will be initialized on a container element (default 'div'), using the container template.
     * A default `callback` will be setup in this case to display the selected range value within
     * the container.
     */
    public $hideInput = false;

    /**
     * @var boolean whether you are using the picker with a input group addon. You can set it
     * to `true`, when `hideInput` is false, and you wish to show the picker position more
     * correctly at the input-group-addon icon. A default `callback` will be setup in this case
     * to generate the selected range value for the input.
     */
    public $useWithAddon = false;

    /**
     * @var initialize all the list values set in `pluginOptions['ranges']`
     * and convert all values to yii\web\JsExpression
     */
    public $initRangeExpr = true;

    /**
     * @var boolean show a preset dropdown. If set to true, this will automatically generate
     * a preset list of ranges for selection. Setting this to true will also automatically
     * set `initRangeExpr` to true.
     */
    public $presetDropdown = false;

    /**
     * @var boolean whether the widget should automatically format the date from
     * the PHP DateTime format to the Moment Datetime format
     * @see http://php.net/manual/en/function.date.php
     * @see http://momentjs.com/docs/#/parsing/string-format/
     */
    public $convertFormat = false;

    /**
     * @var array the HTML attributes for the container, if hideInput is set
     * to true. The following special options are recognized:
     * `tag`: string, the HTML tag for rendering the container. Defaults to `div`.
     */
    public $containerOptions = ['class' => 'drp-container input-group'];

    /**
     * @var array the template for rendering the container, when hideInput is set
     * to true. The special tag `{input}` will be replaced with the hidden form input.
     * In addition, the element with css class `range-value` will be replaced by the
     * calculated plugin value.
     */
    public $containerTemplate = <<< HTML
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
        <span class="form-control text-right">
            <span class="pull-left">
                <span class="range-value"></span>
            </span>
            <b class="caret"></b>
            {input}
        </span>
HTML;

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->convertFormat && isset($this->pluginOptions['format'])) {
            $this->pluginOptions['format'] = static::convertDateFormat($this->pluginOptions['format']);
        }
        $this->initRange();
        echo $this->renderInput();
        $this->registerAssets();
    }

    /**
     * Initializes the pluginOptions range list
     */
    protected function initRange()
    {
        if ($this->presetDropdown) {
            $this->initRangeExpr = true;
            $this->pluginOptions['ranges'] = [
                "Today" => ["moment()", "moment()"],
                "Yesterday" => ["moment().subtract('days', 1)", "moment().subtract('days', 1)"],
                "Last 7 Days" => ["moment().subtract('days', 6)", "moment()"],
                "Last 30 Days" => ["moment().subtract('days', 29)", "moment()"],
                "This Month" => ["moment().startOf('month')", "moment().endOf('month')"],
                "Last Month" => ["moment().subtract('month', 1).startOf('month')", "moment().subtract('month', 1).endOf('month')"],
            ];
            $this->pluginOptions['startDate'] = new JsExpression("moment().subtract('days', 29)");
            $this->pluginOptions['endDate'] = new JsExpression("moment()");
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
     */
    protected static function parseJsExpr($value)
    {
        return $value instanceof JsExpression ? $value : new JsExpression($value);
    }

    /**
     * Renders the input
     *
     * @return string
     */
    protected function renderInput()
    {
        if (!$this->hideInput) {
            Html::addCssClass($this->options, 'form-control');
            return $this->getInput('textInput');
        }
        $this->containerOptions['id'] = $this->options['id'] . '-container';
        $tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
        $content = str_replace('{input}', $this->getInput('hiddenInput'), $this->containerTemplate);
        return Html::tag($tag, $content, $this->containerOptions);
    }

    /**
     * Registers the needed client assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        MomentAsset::register($view);
        $input = '$("#' . $this->options['id'] . '")';
        $id = $input;
        if ($this->hideInput) {
            $id = '$("#' . $this->containerOptions['id'] . '")';
        }
        if (!empty($this->language) && substr($this->language, 0, 2) != 'en') {
            LanguageAsset::register($view)->js[] = 'daterange-' . $this->language . '.js';
            if (empty($this->pluginOptions['locale'])) {
                $this->pluginOptions['locale'] = new JsExpression('dpr_locale_' . $this->language);
            }
        }
        DateRangePickerAsset::register($view);
        $callback = empty($this->callback) ? '' : $this->callback;
        $format = ArrayHelper::getValue($this->pluginOptions, 'format', 'YYYY-MM-DD');
        $separator = ArrayHelper::getValue($this->pluginOptions, 'separator', ' - ');
        if (empty($callback)) {
            if ($this->hideInput) {
                $callback = <<< JS
function(start, end) {
    var val = start.format('{$format}') + '{$separator}' + end.format('{$format}');
    {$id}.find('.range-value').html(val);
    {$input}.val(val);
    {$input}.trigger('change');
}
JS;
            } elseif ($this->useWithAddon) {
                $id = "{$input}.closest('.input-group')";
                $callback = <<< JS
function(start, end) {
    var val = start.format('{$format}') + '{$separator}' + end.format('{$format}');
    {$input}.val(val);
    {$input}.trigger('change');
}
JS;
            } else {
                $this->registerPlugin(self::PLUGIN_NAME, $id);
                return;
            }
        }
        $this->registerPlugin(self::PLUGIN_NAME, $id, null, $callback);
    }

    /**
     * Automatically convert the date format from PHP DateTime to Moment.js DateTime format
     * as required by bootstrap-daterangepicker plugin.
     *
     * @see http://php.net/manual/en/function.date.php
     * @see http://momentjs.com/docs/#/parsing/string-format/
     * @param string $format the PHP date format string
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
}