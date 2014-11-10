<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-date-range
 * @version 1.1.0
 */

namespace kartik\daterange;

/**
 * MomentAsset bundle for \kartik\daterange\DateRangePicker.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class MomentAsset extends \kartik\base\AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/moment']);
        parent::init();
    }

}