<?php

/**
 * This is the model class for table "states".
 *
 * The followings are the available columns in table 'states':
 * @property integer $id
 * @property integer $document_type_id
 * @property integer $state_name_id
 *
 * The followings are the available model relations:
 * @property Claims[] $claims
 * @property StateNames $stateName
 */
class State extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return State the static model class
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
		return 'states';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('document_type_id, state_name_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, document_type_id, state_name_id', 'safe', 'on'=>'search'),
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
			'claims' => array(self::HAS_MANY, 'Claim', 'state_id'),
			'stateName' => array(self::BELONGS_TO, 'StateName', 'state_name_id'),
			'documentType' => array(self::BELONGS_TO, 'DocumentType', 'document_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'document_type_id' => 'Document Type',
			'state_name_id' => 'State Name',
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
		$criteria->compare('document_type_id',$this->document_type_id);
		$criteria->compare('state_name_id',$this->state_name_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
       	public function findStates()
	{
//       		$states = State::model()->findAll(array('order' => 'id'));
//		return CHtml::listData($directions,'id','name');
	}
        
}