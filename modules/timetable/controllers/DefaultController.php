<?php

namespace app\modules\timetable\controllers;

use yii\web\Controller;

/**
 * Default controller for the `timetable` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
