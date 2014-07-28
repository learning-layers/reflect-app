<?php
/**
 * This Class represents the StackController
 * 
 * 
 * @author Andreas Vratny
 * @version 0.1
 * @package application.controllers
 */
class StackController extends Controller {

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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'newStack', 'ImportStack', 'deleteStack', 'editStack', 'switchStackPublicPrivate'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Shows all Stacks of a User
     */
    public function actionIndex() {
        $stacks = Stack::model()->findAll('user_id=:user_id order by created desc', array(':user_id' => Yii::app()->user->id));

        $this->render('index', array(
            'stacks' => $stacks,
        ));
    }

    /**
     * Create a new Stack for a User
     */
    public function actionnewStack() {
        $stack = new Stack();

        $this->validateAjax($stack, 'newstack-form');

        if (isset($_POST['Stack'])) {
            $stack->attributes = $_POST['Stack'];
            if ($this->user->addStack($stack)) {
                $stack = new Stack;
                Yii::app()->user->setFlash('success', 'Your stack has been successfully created!');
                $this->redirect(array('stack/index'));
            }
        } else {
            $this->render('newStack', array('model' => $stack));
        }
    }

    /**
     * Delete the selected stack of a User
     * 
     * @param integer StackID
     */
    public function actiondeleteStack($id) {

        if ($this->user->deleteStackbyId($id)) {
            Yii::app()->user->setFlash('success', 'Selected stack has been deleted!');
        }
        else
            Yii::app()->user->setFlash('error', 'Error while deleting stack! Maybe you do not own this stack?');
        $this->redirect(array('stack/index'));
    }

    /**
     * Edit the selected stack of a User
     * 
     * @param integer StackID
     */
    public function actioneditStack($id) {
        $stack = $this->user->findStackbyid($id);

        if ($stack == NULL) {
            $this->redirect(array('stack/index'));
        }

        $this->validateAjax($stack, 'stackedit-form');

        if (isset($_POST['Stack'])) {
            $stack->attributes = $_POST['Stack'];
            if ($this->user->editStack($stack)) {
                Yii::app()->user->setFlash('success', 'Selected stack has been updated!');
                $this->redirect(array('stack/index'));
            }
            else
                $this->render('editStack', array('model' => $stack));
        } else {
            $this->render('editStack', array('model' => $stack));
        }
    }

    /**
     * Switch a Stack from private mode to public or public to private
     * 
     * @param integer StackID
     */
    public function actionswitchStackPublicPrivate($id) {
        $stack = $this->user->findStackbyid($id);

        if ($stack == NULL) {
            $this->redirect(array('stack/index'));
        }

        if ($this->user->ownsStack($stack)) {
            $stack->public = !$stack->public;
            $stack->publickey = Stack::getPublicKey();
            $stack->save();
        }

        $this->redirect(array('stack/index'));
    }

     /**
     * Import a Stack with a public code
     * 
     */
    public function actionImportStack() {
        $StackImportForm = new StackImportForm();

        $this->validateAjax($StackImportForm, 'stackimport-form');

        if (isset($_POST['StackImportForm'])) {
            $StackImportForm->attributes = $_POST['StackImportForm'];
            if ($StackImportForm->validate()) {
                $importStack = Stack::model()->find('publickey=:publickey', array(':publickey' => $StackImportForm->publickey));

                if ($importStack == NULL) {
                    Yii::app()->user->setFlash('error', 'The public key was not found!');
                    $this->redirect(array('stack/index'));
                }

                if (!$importStack->public) {
                    Yii::app()->user->setFlash('error', 'The public is not valid or the stack is now private!');
                    $this->redirect(array('stack/index'));
                }

                $newStack = new Stack();
                $newStack->user_id = $this->user->id;
                $newStack->description = $importStack->description;
                $newStack->name = $importStack->name;
                $newStack->save();

                foreach ($importStack->questions as $question) {
                    $newQuestion = new Question();
                    $newQuestion->category_id = $question->category_id;
                    $newQuestion->name = $question->name;
                    $newQuestion->stack_id = $newStack->id;
                    $newQuestion->save();
                }

                Yii::app()->user->setFlash('success', 'Stack was successfully imported!');
                $this->redirect(array('stack/index'));
            }
        } else {
            $this->render('importStack', array('model' => $StackImportForm));
        }
    }

}
