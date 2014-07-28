<?php
/**
 * This Class represents the UserController
 * 
 * 
 * @author Andreas Vratny
 * @version 0.1
 * @package application.controllers
 */
class UserController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'register', 'forgotPassword'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'changePassword'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Registration for a User
     * 
     */
    public function actionRegister() {
        $model = new User();
        //$model->scenario = 'needpassword';
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['User'])) {
            if ($model->register($_POST['User'])) {
                $model = new User;
                Yii::app()->user->setFlash('success', 'Thank you for registration. Please check your mails!');
                // $this->render('register', array('model' => $model));
                $this->redirect(array('site/login'));
            } else {
                $this->render('register', array('model' => $model));
            }
        } else {
            $this->render('register', array('model' => $model));
        }
    }

    /**
     * Render user can now change the password
     * 
     */
    public function actionChangePassword() {
        $model = User::model()->find('id=:id', array(':id' => Yii::app()->user->id));
        $model->scenario = 'needpassword';
        $model->password = '';
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'changepassword-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->changePassword()) {
                Yii::app()->user->setFlash('success', 'Your password has been successfully changed!');
                $this->redirect(array('user/changepassword'));
            } else {
                $this->render('changepassword', array('model' => $model));
            }
        } else {
            $this->render('changepassword', array('model' => $model));
        }
    }

    /**
     * Render User has forgot the password
     * 
     */
    public function actionForgotPassword() {
        $model = new User();
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgotpassword-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['User'])) {

            $model = User::model()->find('email=:email', array(':email' => $_POST['User']['email']));

            if ($model->forgotPassword()) {
                $model = new User;
                Yii::app()->user->setFlash('success', 'Your password has been reseted. Please check your mails!');
                // $this->render('register', array('model' => $model));
                $this->redirect(array('site/login'));
            }
        } else {
            $this->render('forgotpassword', array('model' => $model));
        }
    }

}