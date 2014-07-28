<?php

/**
 * This Class represents the AdminController
 * 
 * 
 * @author Andreas Vratny
 * @version 1.1
 * @package application.controllers
 */
class AnswerController extends Controller {

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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform actions
                'actions' => array('create', 'update', 'index', 'addAnswer', 'editAnswer', 'deleteAnswer', 'updateajax'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Shows all answers in the selected Question
     * 
     * @param integer QuestionID
     */

    public function actionindex($questionID) {
        $question = Question::model()->findByPk($questionID);
        if ($question == null || !$question->stack->ownsQuestion($question)) {
            $this->redirect(array('stack/index'));
        }
        $answers = Answer::model()->findAll('question_id=:question_id order by created desc', array(':question_id' => $questionID));
        $this->render('index', array('answers' => $answers, 'question' => $question));
    }

    /**
     * Add an Answer to the selected Question
     * 
     * @param integer QuestionID
     */

    public function actionaddAnswer($questionId) {
        $answer = new Answer();
        $question = $this->user->findQuestionbyid($questionId);

        $this->validateAjax($answer, 'addanswer-form');

        if (isset($_POST['Answer'])) {
            $answer->attributes = $_POST['Answer'];
            if ($question->addAnswer($answer)) {
                $answer = new Answer;
                Yii::app()->user->setFlash('success', 'Your answer has been successfully added!');
                $this->redirect(array('answer/index', 'questionID' => $question->id));
            } else {
                $this->render('addAnswer', array('model' => $answer));
            }
        } else {
            $this->render('addAnswer', array('model' => $answer));
        }
    }

    /**
     * Edit the selected Answer
     * 
     * @param integer AnswerID
     */

    public function actioneditAnswer($id) {
        $answer = $this->user->findAnswerbyid($id);

        if ($answer == NULL) {
            $this->redirect(array('stack/index'));
        }

        $this->validateAjax($answer, 'answeredit-form');

        if (isset($_POST['Answer'])) {
            $answer->attributes = $_POST['Answer'];
            if ($answer->question->editAnswer($answer)) {
                Yii::app()->user->setFlash('success', 'Selected answer has been updated!');
                $this->redirect(array('answer/index', 'questionID' => $answer->question->id));
            }
            else
                $this->render('editAnswer', array('model' => $answer));
        } else {
            $this->render('editAnswer', array('model' => $answer));
        }
    }

    /**
     * Delete the selected Answer
     * 
     * @param integer AnswerID
     */

    public function actiondeleteAnswer($id) {
        $answer = $this->user->findAnswerbyid($id);

        if ($answer == NULL) {
            $this->redirect(array('stack/index'));
        }

        if ($answer->question->deleteAnswer($answer)) {
            Yii::app()->user->setFlash('success', 'Selected answer has been deleted!');
        }
        else
            Yii::app()->user->setFlash('error', 'Error while deleting answer! Maybe you do not own this answer?');
        $this->redirect(array('answer/index', 'questionID' => $answer->question->id));
    }

}

?>