<?php

namespace app\controllers;

use app\models\Client;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\helpers\TwilioSMSHelper;

class ClientController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex() {

        $query = Client::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);

        $clients = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $this->view->title = 'Clients';

        return $this->render(
            'index',
            [
                'clients'    => $clients,
                'pagination' => $pagination
            ]
        );
    }

    public function actionNotify() {
        $request = Yii::$app->request;
        $clientIds = $request->post('clients');
        $smsContent = $request->post('smsContent');
        $clients = [];
        foreach ($clientIds as $clientId) {
            $clients[] = Client::findOne($clientId);
        }
        $smsHelper = new TwilioSMSHelper();
        $smsHelper->sendBulkNotifications($clients, $smsContent);

        return $this->asJson(
            [
                'message' => 'Notifications sent successfully'
            ]
        );
    }

}
