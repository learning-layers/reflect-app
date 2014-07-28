<?php

/**
 * This is the model class for table "questions".
 *
 * The followings are the available columns in table 'questions':
 * @property integer $id
 * @property integer $public
 * @property string $name
 * @property integer $visible
 * @property integer $stack_id
 * @property integer $category_id
 * @property integer $rating
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Answers[] $answers
 * @property Categories $category
 * @property Stacks $stack
 * @property Ratings[] $ratings
 */
class Question extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Question the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'questions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('public, blocked, stack_id, category_id, rating', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 250),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, public, name, blocked, stack_id, category_id, rating, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answers' => array(self::HAS_MANY, 'Answer', 'question_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'stack' => array(self::BELONGS_TO, 'Stack', 'stack_id'),
            'ratings' => array(self::HAS_MANY, 'Rating', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'public' => 'This question is visible for all users',
            'name' => 'Question',
            'blocked' => 'Blocked',
            'stack_id' => 'Stack',
            'category_id' => 'Category',
            'rating' => 'Rating',
            'created' => 'Created',
            'rating_count' => 'Rating Count',
            'rating_sum' => 'Rating Sum'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (strtolower($this->public) == 'yes') {
            $this->public = 1;
        } else if (strtolower($this->public) == 'no') {
            $this->public = 0;
        }
        if (strtolower($this->blocked) == 'yes') {
            $this->blocked = 1;
        } else if (strtolower($this->blocked) == 'no') {
            $this->blocked = 0;
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('public', $this->public);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('blocked', $this->blocked);
        $criteria->compare('stack_id', $this->stack_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Check that this user has already voted this Question
     * 
     * @return boolean User has already voted
     */
    public function userHasVoted() {
        return 1 == Rating::model()->count('user_id=:user_id and question_id=:question_id', array('user_id' => Yii::app()->user->id, 'question_id' => $this->id));
    }

    /**
     * Create a new Question in a Stack
     * 
     * @param type $data
     * @param type $stackId
     * @return boolean
     */
    public function newQuestion($data, $stackId) {
        $this->attributes = $data;

        $stack = User::model()->findByPk($id);
        if ($stack)
            $this->stack_id = $stack_id;

        $this->user_id = Yii::app()->user->id;
        if ($this->validate()) {

            $this->save();
            return true;
        }
        else
            return false;
    }

    /**
     * Add a Rating to this Question
     * 
     * @param type $rating
     * @return boolean
     */
    public function addRating($rating) {
        if ($this->isFirstRating()) {
            $rating->question_id = $this->id;
            return $rating->save();
        }
        else
            return false;
    }

    /**
     * Check is this the first Rating
     * 
     * @return boolean
     */
    public function isFirstRating() {
        return 0 == Rating::model()->count('user_id=:user_id and question_id=:question_id', array(':user_id' => Yii::app()->user->id, ':question_id' => $this->id));
    }

    /**
     * Add a Answer to the Question
     * 
     * @param type $answer
     * @return boolean
     */
    public function addAnswer($answer) {
        if ($this->stack->ownsQuestion($this)) {
            $answer->question_id = $this->id;
            return $answer->save();
        }
        else
            return false;
    }

    /**
     * Delete Answer
     * 
     * @param type $answer
     * @return boolean
     */
    public function deleteAnswer($answer) {
        if ($this->ownsAnswer($answer)) {
            return $answer->delete();
        } else {
            return false;
        }
    }

    /**
     * Edit Answer
     * 
     * @param type $answer
     * @return boolean
     */
    public function editAnswer($answer) {
        if ($this->ownsAnswer($answer)) {
            return $answer->save();
        } else {
            return false;
        }
    }

    /**
     * Is current logged in User the owner of the Answer
     * 
     * @param type $answer
     * @return boolean
     */
    public function ownsAnswer($answer) {
        return ($this->stack->ownsQuestion($this) && $answer->question_id = $this->id);
    }

    /**
     * How many Answers has got this question
     * 
     * @return integer
     */
    public function answerCount() {
        return Answer::model()->count('question_id=:question_id', array(':question_id' => $this->id));
    }

}