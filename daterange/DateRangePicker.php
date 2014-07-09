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
     * @var boolean whether the widget should automatically format the date from
     * the PHP DateTime format to the Bootstrap DateRangePicker plugin format
     * @see http://php.net/manual/en/function.date.php
     * @see https://github.com/dangrossman/bootstrap-daterangepicker#options
     */
    public $convertFormat = false;

    /**
     * @var string the javascript callback to be passed to the plugin constructor
     * @see https://github.com/dangrossman/bootstrap-daterangepicker#options
     */
    public $callback;
    
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
        $this->registerAssets();
        echo $this->getInput();
    }
    
    /**
     * Registers the needed client assets
     */  
    public function registerAssets()
    {
        $view = $this->getView();
        DateRangePickerAsset::register($view);
        if (empty($this->callback)) {
            $this->registerPlugin(self::PLUGIN_NAME);
        }
        else {
            $this->registerPlugin(self::PLUGIN_NAME, null, null, $this->callback);
        }
    }
}