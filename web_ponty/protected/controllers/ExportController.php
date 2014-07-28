<?php
/**
 * This Class represents the ExportController
 * 
 * 
 * @author Andreas Vratny
 * @version 0.1
 * @package application.controllers
 */
class ExportController extends Controller {

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
                'actions' => array('index', 'exporttxt', 'ExportMail'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Shows the Indexpage of exporting the Stacks
     * 
     */

    public function actionIndex() {
        $stacks = Stack::model()->findAll('user_id=:user_id order by created desc', array(':user_id' => Yii::app()->user->id));

        $this->render('index', array(
            'stacks' => $stacks,
        ));
    }

    /**
     * Export a selected Stack to a textfile and send it to user
     * 
     * @param integer StackID
     */

    public function actionExporttxt($id) {
        $stack = $this->user->findStackbyid($id);
        if ($stack == null) {
            $this->redirect(array('export/index'));
        }
        $content = '';
        foreach ($stack->questions as $question) {
            $content = $content . '------------------------------------------------------------------------------------------' . "\r\n";
            $content = $content . wordwrap($question->name, 90, "\r\n") . "\r\n";
            $content = $content . '------------------------------------------------------------------------------------------' . "\r\n";
            $content = $content . "\r\n";

            foreach ($question->answers as $answer) {
                $content = $content . "Answer from " . $answer->created . ':' . "\r\n";
                $content = $content . wordwrap($answer->text, 90, "\r\n") . "\r\n";

                $content = $content . "\r\n";
                $content = $content . "\r\n";
            }
            $content = $content . "\r\n";
            $content = $content . "\r\n";
        }

        $filename = str_replace(' ', '_', $stack->name);
        $filename = substr($filename, 0, 8) . '.txt';
        Yii::app()->getRequest()->sendFile($filename, $content, "text/plain", false);
    }

    /**
     * Export a selected Stack to a E-Mail and send it to user
     * 
     * @param integer StackID
     */

    public function actionExportMail($stackID) {

        $formModel = new MailExportForm();

        $this->validateAjax($formModel, 'mailnow');

        if (isset($_POST['MailExportForm'])) {
            $formModel->attributes = $_POST['MailExportForm'];

            if ($formModel->validate()) {

                $message = new YiiMailMessage;
                $message->view = 'ExportStack';

                $stack = $this->user->findStackbyid($stackID);
                if ($stack == null) {
                    $this->redirect(array('export/index'));
                }
                $content = '';
                foreach ($stack->questions as $question) {
                    $content = $content . '------------------------------------------------------------------------------------------' . "\r\n";
                    $content = $content . wordwrap($question->name, 90, "</br>") . "\r\n";
                    $content = $content . '------------------------------------------------------------------------------------------' . "\r\n";
                    $content = $content . "\r\n";

                    foreach ($question->answers as $answer) {
                        $content = $content . "Answer from " . $answer->created . ':' . "\r\n";
                        $content = $content . wordwrap($answer->text, 90, "\r\n") . "\r\n";

                        $content = $content . "\r\n";
                        $content = $content . "\r\n";
                    }
                    $content = $content . "\r\n";
                    $content = $content . "\r\n";
                }

                $formModel->stack = $content;

                //userModel is passed to the view
                $formModel->body = str_replace("\r\n", '</br>', $formModel->body);
                $formModel->stack = str_replace("\r\n", '</br>', $formModel->stack);
                $message->setBody(array('model' => $formModel), 'text/html');

                $message->addTo($formModel->email);
                $message->setSubject($formModel->subject);
                $message->from = Yii::app()->user->getState('email');
                Yii::app()->mail->send($message);
                Yii::app()->user->setFlash('success', 'Thank you! E-Mail was sent!');
                $this->redirect(array('export/index'));
            } else {
                $this->render('ExportMail', array('model' => $formModel));
            }
        } else {

            $stack = $this->user->findStackbyid($stackID);
            if ($stack == null) {
                $this->redirect(array('export/index'));
            }
            $content = '';
            foreach ($stack->questions as $question) {
                $content = $content . '------------------------------------------------------------------------------------------' . "\r\n";
                $content = $content . wordwrap($question->name, 90, "</br>") . "\r\n";
                $content = $content . '------------------------------------------------------------------------------------------' . "\r\n";
                $content = $content . "\r\n";

                foreach ($question->answers as $answer) {
                    $content = $content . "Answer from " . $answer->created . ':' . "\r\n";
                    $content = $content . wordwrap($answer->text, 90, "\r\n") . "\r\n";

                    $content = $content . "\r\n";
                    $content = $content . "\r\n";
                }
                $content = $content . "\r\n";
                $content = $content . "\r\n";
            }

            $formModel->stack = $content;

            $this->render('ExportMail', array('model' => $formModel));
        }
    }

}
