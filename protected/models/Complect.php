<?php

/**
 * This is the model class for table "complects".
 *
 * The followings are the available columns in table 'complects':
 * @property integer $id
 * @property integer $complect_type_id
 * @property string $name
 * @property string $comment
 */
class Complect extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Complect the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'complects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('complect_type_id', 'numerical', 'integerOnly'=>true),
			array('name, comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, complect_type_id, name, comment', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'complectLines' => array(self::HAS_MANY, 'ComplectLine', 'complect_id'),
                    'complectType' => array(self::BELONGS_TO, 'ComplectType', 'complect_type_id' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'complect_type_id' => 'Complect Type',
			'name' => 'Name',
			'comment' => 'Comment',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('complect_type_id',$this->complect_type_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function findComplects()
        {
            $complects = Complect::model()->findAll(array('order' => 'name'));
            return CHtml::listData($complects,'id','name');
        }
}