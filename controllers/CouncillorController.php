<?php

namespace app\controllers;

use app\models\Councillor;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\web\Controller;

class CouncillorController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     * @throws GuzzleException
     */
    public function actionIndex()
    {
        $pageNumber = Yii::$app->request->get('pageNumber', 1);

        $model = new Councillor();
        $councillors = $model->getCouncillorsByPageNumber($pageNumber);

        return $this->render('index', [
            'data' => $councillors
        ]);
    }

    /**
     * Displays 5 random elements
     *
     * @throws GuzzleException
     */
    public function actionRandom()
    {
        $model = new Councillor();
        $councillors = $model->getAllCouncillors();

        shuffle($councillors);
        $fiveElements =  array_slice($councillors, 0, 5);

        return $this->render('random', [
            'data' => $fiveElements
        ]);
    }

    /**
     * Displays details page.
     *
     * @return string
     * @throws GuzzleException
     */
    public function actionDetails()
    {
        $id = Yii::$app->request->get('id');

        $model = new Councillor();
        $councillor = $model->getCouncillor($id);

        return $this->render('details', [
            'data' => $councillor
        ]);
    }

    /**
     * Displays order page
     *
     * @return string
     * @throws GuzzleException
     */
    public function actionOrder()
    {
        $order = Yii::$app->request->get('order');

        $model = new Councillor();
        $councillors = $model->getAllCouncillors();

        $councillors = $model->sortByNameOrLastName($order, $councillors);

        return $this->render('order', [
            'data' => $councillors
        ]);
    }
}
