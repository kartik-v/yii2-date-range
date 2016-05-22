<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2016
 * @package yii2-date-range
 * @version 1.6.7
 */

namespace kartik\daterange;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Language Asset bundle for \kartik\daterange\DateRangePicker.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class LanguageAsset extends AssetBundle
{
    public $jsOptions = ['position' => View::POS_HEAD];
    public $depends = ['\kartik\daterange\MomentAsset'];
    public $sourcePath = __DIR__ . '/assets';
}
