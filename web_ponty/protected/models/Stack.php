<?php

/**
 * This is the model class for table "stacks".
 *
 * The followings are the available columns in table 'stacks':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $user_id
 * @property string $created
 * @property boolean $public
 * @property string $publickey
 *
 * The followings are the available model relations:
 * @property Questions[] $questions
 * @property Users $user
 */
class Stack extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Stack the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'stacks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, user_id', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 250),
            array('description, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, user_id, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //  'questions' => array(self::HAS_MANY, 'Question', 'stack_id', 'order'=>'created desc'),
            'questions' => array(self::HAS_MANY, 'Question', 'stack_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'user_id' => 'User',
            'created' => 'Created',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('publickey', $this->publickey, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Add a Question to the Stack
     *  
     * @param type $question
     * @return boolean
     */
    public function addQuestion($question) {
        if ($this->user->ownsStack($this)) {
            $question->stack_id = $this->id;
            return $question->save();
        }
        else
            return false;
    }

    /**
     * Delete the Question from Stack
     * 
     * @param type $question
     * @return boolean
     */
    public function deleteQuestion($question) {
        if ($this->ownsQuestion($question)) {
            return $question->delete();
        } else {
            return false;
        }
    }

    /**
     * Edit Question in Stack
     * 
     * @param type $question
     * @return boolean
     */
    public function editQuestion($question) {
        if ($this->ownsQuestion($question)) {
            return $question->save();
        } else {
            return false;
        }
    }

    /**
     * Is current logged in User owner of the Question
     * 
     * @param type $question
     * @return boolean
     */
    public function ownsQuestion($question) {
        return ($this->user->ownsStack($this) && $question->stack_id = $this->id);
    }

    /**
     * 
     * @return string Randompassword
     */
    public static function getPublicKey() {
        $key = '';
        $vorhanden = true;
        while ($vorhanden) {
            $length = 8;
            $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
            shuffle($chars);
            $key = implode(array_slice($chars, 0, $length));

            $count = Stack::model()->count('publickey=:publickey', array(':publickey' => $key));

            $vorhanden = $count > 0;
        }
        return $key;
    }

}