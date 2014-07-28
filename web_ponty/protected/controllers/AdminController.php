<?php
/**
 * This Class represents the AdminController
 * 
 * 
 * @author Andreas Vratny
 * @version 0.1
 * @package application.controllers
 */

class AdminController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout = '//layouts/column2';

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
                'expression' => '$user->isAdmin',
                'actions' => array('index', 'publicquestions'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    
    /**
     * Shows the Indexpage of the Admininterface
     */
    public function actionIndex() {


        $this->render('index');
    }

}
