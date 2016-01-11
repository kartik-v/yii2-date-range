<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2016
 * @package yii2-date-range
 * @version 1.6.6
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

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        parent::init();
    }

}