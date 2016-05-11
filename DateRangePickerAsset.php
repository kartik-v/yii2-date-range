<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2016
 * @package yii2-date-range
 * @version 1.6.7
 */

namespace kartik\daterange;

use kartik\base\AssetBundle;

/**
 * DateRangePicker bundle for \kartik\daterange\DateRangePicker.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DateRangePickerAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->depends = array_merge($this->depends, ['kartik\daterange\MomentAsset']);
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/daterangepicker', 'css/daterangepicker-kv']);
        $this->setupAssets('js', ['js/daterangepicker']);
        parent::init();
    }
}
