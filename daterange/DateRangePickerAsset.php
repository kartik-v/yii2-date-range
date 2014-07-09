<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-date-range
 * @version 1.0.0
 */

namespace kartik\daterange;    

/**
 * DateRangePicker bundle for \kartik\daterange\DateRangePicker.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DateRangePickerAsset extends \kartik\widgets\AssetBundle
{   
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/../assets');
        $this->setupAssets('css', ['css/daterangepicker']);
        $this->setupAssets('js', ['js/moment', 'js/daterangepicker']);
        parent::init();
    }

}