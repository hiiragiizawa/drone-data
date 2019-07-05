<?php
namespace frontend\controllers;

use Yii;
use yii\rest\Controller;
use yii\helpers\Json;

use common\models\Data;

/**
 * Site controller
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionPush()
    {
        $model = new Data;
        $model->data_json = Yii::$app->request->getBodyParam('data');

        return [
            'status' => $model->save(),
            'content' => $model->data_json,
        ];
    }

    public function actionFetch($timestamp)
    {
        $model = Data::find()->where([
            '>', 'created_at', $timestamp
        ])->orderBy('created_at ASC')->one();

        if ($model) {
            return [
                'data' => Json::decode($model->data_json),
                'timestamp' => $model->created_at,
            ];
        }

        return null;
    }
}
