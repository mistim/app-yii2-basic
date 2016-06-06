<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\LoginForm;
use Yii;

/**
 * Class MainController
 * @package app\modules\admin\controllers
 */
class MainController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->redirect('/admin');
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goBack();
        }
        else
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/admin');
    }

    /**
     * TODO
     * @return \yii\web\Response
     */
    /*public function actionFlushCache(){
        if (Admin::isAdmin()){
            Cache::flush();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }*/
}