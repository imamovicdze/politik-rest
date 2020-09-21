<?php

namespace app\controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @param int $pageNumber
     * @return string
     * @throws GuzzleException
     */
    public function actionIndex($pageNumber = 1)
    {
        $pageNumber = Yii::$app->request->get('pageNumber');

        $client = new Client();

        $res = $client->request('GET', 'http://ws-old.parlament.ch/councillors?format=json&pageNumber=' . $pageNumber, [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $decodedPosts = '';
        if ($res->getStatusCode() == 200) {
            $decodedPosts = json_decode($res->getBody());
        }

        return $this->render('index', [
            'data' => $decodedPosts
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays 5 random elements
     *
     */
    public function actionRandom()
    {
        $client = new Client();

        $res = $client->request('GET', 'http://ws-old.parlament.ch/councillors?format=json', [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        if ($res->getStatusCode() == 200) {
            $decodedPosts = json_decode($res->getBody());
            shuffle($decodedPosts);
            $fiveElements = array_slice($decodedPosts, 0, 5);
        }

        return $this->render('random', [
            'data' => $fiveElements
        ]);
    }

    /**
     * Displays details page.
     *
     * @return string
     */
    public function actionDetails()
    {
        $id = Yii::$app->request->get('id');

        $client = new Client();

        $res = $client->request('GET', 'http://ws-old.parlament.ch/councillors/' . $id .'?format=json', [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $decodedPost = '';
        if ($res->getStatusCode() == 200) {
            $decodedPost = json_decode($res->getBody());
        }

        return $this->render('details', [
            'data' => $decodedPost
        ]);
    }
}
