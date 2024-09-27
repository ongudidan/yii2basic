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
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        "/web/dashboard/assets/plugins/bootstrap/css/bootstrap.min.css",
        "/web/dashboard/assets/plugins/feather/feather.css",
        "/web/dashboard/assets/plugins/icons/flags/flags.css",
        "/web/dashboard/assets/plugins/fontawesome/css/fontawesome.min.css",
        "/web/dashboard/assets/plugins/fontawesome/css/all.min.css",
        "/web/dashboard/assets/css/style.css",
        "/web/dashboard/assets/plugins/datatables/datatables.min.css"
    ];
    public $js = [
        // "/web/dashboard/assets/js/jquery-3.6.0.min.js",
        "/web/dashboard/assets/plugins/bootstrap/js/bootstrap.bundle.min.js",
        "/web/dashboard/assets/js/feather.min.js",
        "/web/dashboard/assets/plugins/slimscroll/jquery.slimscroll.min.js",
        "/web/dashboard/assets/plugins/apexchart/apexcharts.min.js",
        "/web/dashboard/assets/plugins/apexchart/chart-data.js",
        "/web/dashboard/assets/plugins/datatables/datatables.min.js",
        "/web/dashboard/assets/js/script.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
    
}
