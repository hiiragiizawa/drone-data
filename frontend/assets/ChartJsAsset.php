<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ChartJsAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $css = [
        'chart.js/dist/Chart.css',
    ];
    public $js = [
        'chart.js/dist/Chart.js',
    ];
}
