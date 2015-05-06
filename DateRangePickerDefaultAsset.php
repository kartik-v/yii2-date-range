<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015
 * @package yii2-date-range
 * @version 1.6.1
 */

namespace kartik\daterange;

/**
 * DateRangePickerDefault bundle for \kartik\daterange\DateRangePicker.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DateRangePickerDefaultAsset extends \kartik\base\AssetBundle
{
    public $sourcePath = '@bower/bootstrap-daterangepicker'; 

    public $js = [
        'daterangepicker.js',
    ];
    public $css = [
        'daterangepicker-bs3.css',
    ];
    public $depends = ['yii\web\JqueryAsset','\kartik\daterange\MomentAsset',];


}