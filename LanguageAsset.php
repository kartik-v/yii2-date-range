<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2016
 * @package yii2-date-range
 * @version 1.6.7
 */

namespace kartik\daterange;
use kartik\base\AssetBundle;

/**
 * DateRangeLang bundle for \kartik\daterange\DateRangePicker.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class LanguageAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->depends = array_merge($this->depends, ['\kartik\daterange\MomentAsset']);
        $this->setSourcePath(__DIR__ . '/assets');
        parent::init();
    }
}
