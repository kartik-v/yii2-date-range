<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-date-range
 * @version 1.5.0
 */

namespace kartik\daterange;

/**
 * DateRangeLang bundle for \kartik\daterange\DateRangePicker.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class LanguageAsset extends \kartik\base\AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = ['\kartik\daterange\MomentAsset'];

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        parent::init();
    }

}