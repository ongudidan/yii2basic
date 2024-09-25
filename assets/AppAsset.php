<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        "/web/custom/assets/css/core/libs.min.css",
        "/web/custom/assets/vendor/aos/dist/aos.css",
        "/web/custom/assets/css/hope-ui.min.css",
        "/web/custom/assets/css/custom.min.css",
        "/web/custom/assets/css/dark.min.css",
        "/web/custom/assets/css/customizer.min.css",
        "/web/custom/assets/css/rtl.min.css",
    ];
    public $js = [
        "/web/custom/assets/js/core/libs.min.js",
        "/web/custom/assets/js/core/external.min.js",
        "/web/custom/assets/js/charts/widgetcharts.js",
        "/web/custom/assets/js/charts/vectore-chart.js",
        "/web/custom/assets/js/charts/dashboard.js",
        "/web/custom/assets/js/plugins/fslightbox.js",
        "/web/custom/assets/js/plugins/setting.js",
        "/web/custom/assets/js/plugins/slider-tabs.js",
        "/web/custom/assets/js/plugins/form-wizard.js",
        "/web/custom/assets/vendor/aos/dist/aos.js",
        "/web/custom/assets/js/hope-ui.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
