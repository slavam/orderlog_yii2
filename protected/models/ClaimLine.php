<?php

/**
 * This is the model class for table "claim_lines".
 *
 * The followings are the available columns in table 'claim_lines':
 * @property integer $id
 * @property integer $claim_id
 * @property integer $count
 * @property double $amount
 * @property string $description
 * @property integer $for_whom
 * @property integer $state_id
 * @property string $change_date
 * @property integer $budget_item_id
 * @property integer $asset_id
 * @property double $cost
 * @property integer $business_id
 *
 * The followings are the available model relations:
 * @property AccountLines[] $accountLines
 */
class ClaimLine extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ClaimLine the static model class
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
		return 'claim_lines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('claim_id', 'required'),
			array('claim_id, count, for_whom, state_id, budget_item_id, asset_id, business_id', 'numerical', 'integerOnly'=>true),
			array('amount, cost', 'numerical'),
			array('description, change_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, claim_id, count, amount, description, for_whom, state_id, change_date, budget_item_id, asset_id, cost, business_id', 'safe', 'on'=>'search'),
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
			'accountLines' => array(self::HAS_MANY, 'AccountLines', 'clime_line_id'),
                    'asset' => array(self::BELONGS_TO, 'Asset', 'asset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'claim_id' => 'Claim',
			'count' => 'Count',
			'amount' => 'Amount',
			'description' => 'Description',
			'for_whom' => 'For Whom',
			'state_id' => 'State',
			'change_date' => 'Change Date',
			'budget_item_id' => 'Budget Item',
			'asset_id' => 'Asset',
			'cost' => 'Cost',
			'business_id' => 'Business',
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
		$criteria->compare('claim_id',$this->claim_id);
		$criteria->compare('count',$this->count);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('for_whom',$this->for_whom);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('change_date',$this->change_date,true);
		$criteria->compare('budget_item_id',$this->budget_item_id);
		$criteria->compare('asset_id',$this->asset_id);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('business_id',$this->business_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}