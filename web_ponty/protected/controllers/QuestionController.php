<?php
/**
 * This Class represents the QuestionController
 * 
 * 
 * @author Andreas Vratny
 * @version 0.1
 * @package application.controllers
 */
class QuestionController extends Controller {

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
                'actions' => array('index', 'view', 'publicQuestions'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'addQuestion', 'editQuestion', 'deleteQuestion', 'updateajax', 'publicQuestions', 'rating'),
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
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Question');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Rate a Question
     * 
     * @param integer QuestionID
     * @param boolean Should be validated
     */

    public function actionRating($id, $val) {

        if (Yii::app()->request->isAjaxRequest) {
            $returnString = "Thank you!";
            $question = Question::model()->findByPk($_GET['id']);
            if ($question->userHasVoted()) {
                $oldRating = Rating::model()->find('user_id=:user_id and question_id=:question_id', array('user_id' => Yii::app()->user->id, 'question_id' => $question->id));
                $returnString = "Voting changed from " . $oldRating->rating_value . " to " . $_GET['val'];
                $question->rating_sum = $question->rating_sum - $oldRating->rating_value;
                $question->rating_count = $question->rating_count - 1;
                $oldRating->delete();
            }

            $question->rating_count = $question->rating_count + 1;
            $question->rating_sum = $question->rating_sum + $_GET['val'];
            $question->rating = round($question->rating_sum / $question->rating_count, 0);

            if ($question->save()) {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => '<br>' . $returnString,
                    'info' => "&nbsp;&nbsp;&nbsp;&nbsp;" . $question->rating_count . " votes",
                ));
                $rating = new Rating();
                $rating->user_id = Yii::app()->user->id;
                $rating->question_id = $_GET['id'];
                $rating->rating_value = $_GET['val'];
                $rating->save();
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => 'ERROR',
                    'info' => "Rating: " . $question->rating . " " . $question->rating_count . " votes",
                ));
            }
        }
    }

    /**
     * Showing public Question to choose from it
     * 
     * @param string Category
     */

    public function actionpublicQuestions($category = NULL) {
        if ($category == NULL || $category == "TOP10") {
            $questions = Question::model()->findAll('public=:public order by rating desc limit 10', array(':public' => 1));
            //$categories = Category::model()->findAll();
        } else {
            if ($category == "nocat") {
                $questions = Question::model()->findAll('public=:public and category_id is null order by rating desc limit 10', array(':public' => 1));
            } else {
                $questions = Question::model()->findAll('public=:public and category_id=:category_id order by rating desc limit 10', array(':public' => 1, ':category_id' => $category));
            }
        }
        $this->render('publicQuestions', array(
            'questions' => $questions, 'category' => $category,
        ));
    }

    /**
     * Add a Question to a Stack.
     * 
     * @param integer StackID
     * @param integer QuestionID from wich will copy it
     */

    public function actionaddQuestion($stackId, $questionid = NULL) {
        $question = new Question();
        if ($questionid != NULL) {
            $copyquestion = Question::model()->findByPk($questionid);
            $question->name = $copyquestion->name;
            $question->category_id = $copyquestion->category_id;
        }
        $stack = $this->user->findStackbyId($stackId);
        $this->validateAjax($question, 'addquestion-form');
        if ($stackId > 0) {
            Yii::app()->user->setState('stackid', $stackId);
        }
        if (isset($_POST['Question'])) {
            $question->attributes = $_POST['Question'];
            if ($stack->addQuestion($question)) {
                $question = new Question;
                Yii::app()->user->setFlash('success', 'Your question has been successfully added!');
                Yii::app()->user->setState('stackid', -1);
                $this->redirect(array('stack/index'));
            } else {
                $this->render('addQuestion', array('model' => $question));
            }
        } else {
            $this->render('addQuestion', array('model' => $question));
        }
    }

    /**
     * Edit a Question
     * 
     * @param integer QuestionID
     */
    public function actioneditQuestion($id) {
        $question = $this->user->findQuestionbyid($id);

        if ($question == NULL) {
            $this->redirect(array('stack/index'));
        }

        $this->validateAjax($question, 'questionedit-form');

        if (isset($_POST['Question'])) {
            $question->attributes = $_POST['Question'];
            if ($question->stack->editQuestion($question)) {
                Yii::app()->user->setFlash('success', 'Selected question has been updated!');
                $this->redirect(array('stack/index'));
            }
            else
                $this->render('editQuestion', array('model' => $question));
        } else {
            $this->render('editQuestion', array('model' => $question));
        }
    }

    /**
     * Delete a Question
     * 
     * @param integer QuestionID
     */
    public function actiondeleteQuestion($id) {
        $question = $this->user->findQuestionbyid($id);

        if ($question == NULL) {
            $this->redirect(array('stack/index'));
        }

        if ($question->stack->deleteQuestion($question)) {
            Yii::app()->user->setFlash('success', 'Selected question has been deleted!');
        }
        else
            Yii::app()->user->setFlash('error', 'Error while deleting question! Maybe you do not own this question?');
        $this->redirect(array('stack/index'));
    }

}
