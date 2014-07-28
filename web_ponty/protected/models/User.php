<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $is_admin
 * @property integer $blocked
 *
 * The followings are the available model relations:
 * @property Ratings[] $ratings
 * @property Stacks[] $stacks
 */
class User extends CActiveRecord {

    public $repeat_password;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('email, password', 'required'),
            array('is_admin, blocked', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 250),
            array('email', 'unique'),
            array('email', 'email'),
            array('email', 'trashmail'),
            array('created', 'safe'),
            array('password', 'length', 'max' => 500,'on' => 'needpassword'),
            array('password, repeat_password', 'required', 'on' => 'needpassword'),
            array('password, repeat_password', 'length', 'min' => 6, 'max' => 40,'on' => 'needpassword'),
            array('password', 'compare', 'compareAttribute' => 'repeat_password','on' => 'needpassword'),
            // The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, email, password, is_admin, blocked', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'ratings' => array(self::HAS_MANY, 'Rating', 'user_id'),
            'stacks' => array(self::HAS_MANY, 'Stack', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'is_admin' => 'Is Admin',
            'blocked' => 'Blocked',
            'created' => 'Created'
        );
    }

    public function getBlockedLocalized() {
        return Yii::t('boolean', $this->blocked);
    }

    public function getIsAdminLocalized() {
        return Yii::t('boolean', $this->is_admin);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
// Warning: Please modify the following code to remove attributes that
// should not be searched.

        $criteria = new CDbCriteria;
        
        if (strtolower($this->is_admin) == 'yes') {
            $this->is_admin = 1;
        }
        else if (strtolower($this->is_admin) == 'no') {
            $this->is_admin = 0;
        }
        if (strtolower($this->blocked) == 'yes') {
            $this->blocked = 1;
        }
        else if (strtolower($this->blocked) == 'no') {
            $this->blocked = 0;
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('is_admin', $this->is_admin);
        $criteria->compare('blocked', $this->blocked);
        $criteria->compare('created', $this->created);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 
     * @return Randompassword
     */
    public static function getRandomPassword() {
        $length = 8;
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($chars);
        return implode(array_slice($chars, 0, $length));
    }

    /**
     * Register a User with sending E-Mail
     * 
     * @return boolean Is register successfull
     */
    public function register($data) {
        $this->attributes = $data;
        $this->is_admin = 0;
        $this->blocked = 0;
        $this->password = User::getRandomPassword();
        $this->repeat_password = $this->password;
        if ($this->validate()) {



            //Start Mailing
            $message = new YiiMailMessage;
            $message->view = 'newRegistrationPassword';

            //userModel is passed to the view
            $message->setBody(array('password' => $this->password), 'text/html');
            $message->setSubject('Your Registration for Pontydysgu LearningApp');
            $message->addTo($this->email);
            $message->from = Yii::app()->params['adminEmail'];
            Yii::app()->mail->send($message);
            $this->password = sha1($this->password);
            return  $this->save();
        }
        else
            return false;
    }

    /**
     * Send the User a new Password
     * 
     * @return boolean
     */
    public function forgotPassword() {
        //Start Mailing
        $this->password = User::getRandomPassword();
        $message = new YiiMailMessage;
        $message->view = 'forgotPassword';
        //userModel is passed to the view
        $message->setBody(array('password' => $this->password), 'text/html');
        $message->setSubject('New password request');
        $message->addTo($this->email);
        $message->from = Yii::app()->params['adminEmail'];
        Yii::app()->mail->send($message);
        $this->password = sha1($this->password);
        $this->save();
        return true;
    }

    /**
     * Change the Password
     * 
     * @return boolean Is password change successfull
     */
    public function changePassword() {
        if ($this->validate()) {
            $this->password = sha1($this->password);
            $this->repeat_password=  $this->password;
            return $this->save();
        }
        else
            return false;
    }

    /**
     * Add a Stack for the current User
     * 
     * @return boolean Was adding stack successfull
     */
    public function addStack($stack) {
        $stack->user_id = $this->id;
        return $stack->save();
    }

    /**
     * Delete Stack
     * 
     * @param type $stack
     * @return boolean
     */
    public function deleteStack($stack) {
        if ($this->ownsStack($stack)) {
            return $stack->delete();
        } else {
            return false;
        }
    }

    /**
     * Delete Stack by ID
     * 
     * @param type $id
     * @return boolean
     */
    public function deleteStackbyId($id) {
        $stack = Stack::model()->findbyPk($id);
        if ($stack == null) {
            return false;
        }
        else
            return $this->deleteStack($stack);
    }

    /**
     * Edit Stack
     * 
     * @param type $stack
     * @return boolean
     */
    public function editStack($stack) {
        if ($this->ownsStack($stack)) {
            return $stack->save();
        } else {
            return false;
        }
    }

    /**
     * Search a Stack of User by ID
     * 
     * @param type $id
     * @return Stack
     */
    public function findStackbyid($id) {
        $stack = Stack::model()->findbyPk($id);
        if ($stack != null && $this->ownsStack($stack)) {
            return $stack;
        }
        else
            return null;
    }

    /**
     * Search a Answer by ID
     * 
     * @param type $id
     * @return Answer
     */
    public function findAnswerbyid($id) {
        $answer = Answer::model()->findbyPk($id);
        if ($answer != null && $this->ownsAnswer($answer)) {
            return $answer;
        }
        else
            return null;
    }

    /**
     * Search Question by ID
     * 
     * @param type $id
     * @return Question
     */
    public function findQuestionbyid($id) {
        $question = Question::model()->findbyPk($id);
        if ($question != null && $question->stack->ownsQuestion($question)) {
            return $question;
        }
        else
            return null;
    }

    /**
     * Is User owner of Stack
     * 
     * @param type $stack
     * @return boolean
     */
    public function ownsStack($stack) {
        return $stack->user_id == Yii::app()->user->id;
    }

    /**
     * Is User owner of Answer
     * 
     * @param type $answer
     * @return boolean
     */
    public function ownsAnswer($answer) {
        return $this->ownsStack($answer->question->stack);
    }

    
    public function trashmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $email_host = substr($this->email, strrpos($this->email, '@') + 1, strlen($this->email));
            if (TrashMailProvider::model()->count('address=:address', array(':address' => $email_host)) > 0) {
                $this->addError('email', 'Trash mails are not allowed!');
            }
        }
    }

}