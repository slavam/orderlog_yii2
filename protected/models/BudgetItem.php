<?php

/**
 * This is the model class for table "FIN.BUDGET_DIRECTORY".
 *
 * The followings are the available columns in table 'FIN.BUDGET_DIRECTORY':
 * @property integer $ID
 * @property string $CODE
 * @property string $NAME
 * @property string $DESCRIPTION
 * @property integer $PARENT_ID
 * @property string $DATE_ADD
 * @property string $DATE_CLOSED
 * @property integer $BUDGET_GROUPS_ID
 * @property integer $SIGN
 */
class BudgetItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BudgetItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function getDbConnection(){
	        return Yii::app()->db1;
        }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'FIN.BUDGET_DIRECTORY';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CODE, NAME, DATE_ADD, BUDGET_GROUPS_ID', 'required'),
			array('PARENT_ID, BUDGET_GROUPS_ID, SIGN', 'numerical', 'integerOnly'=>true),
			array('CODE', 'length', 'max'=>20),
			array('NAME', 'length', 'max'=>255),
			array('DESCRIPTION', 'length', 'max'=>400),
			array('DATE_CLOSED', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CODE, NAME, DESCRIPTION, PARENT_ID, DATE_ADD, DATE_CLOSED, BUDGET_GROUPS_ID, SIGN', 'safe', 'on'=>'search'),
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
                    'claimLines' => array(self::HAS_MANY, 'ClaimLine', 'budget_item_id'),
                    'assets' => array(self::HAS_MANY, 'Asset', 'budget_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'CODE' => 'Code',
			'NAME' => 'Name',
			'DESCRIPTION' => 'Description',
			'PARENT_ID' => 'Parent',
			'DATE_ADD' => 'Date Add',
			'DATE_CLOSED' => 'Date Closed',
			'BUDGET_GROUPS_ID' => 'Budget Groups',
			'SIGN' => 'Sign',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('CODE',$this->CODE,true);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('PARENT_ID',$this->PARENT_ID);
		$criteria->compare('DATE_ADD',$this->DATE_ADD,true);
		$criteria->compare('DATE_CLOSED',$this->DATE_CLOSED,true);
		$criteria->compare('BUDGET_GROUPS_ID',$this->BUDGET_GROUPS_ID);
		$criteria->compare('SIGN',$this->SIGN);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}