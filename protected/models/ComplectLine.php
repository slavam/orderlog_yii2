<?php

/**
 * This is the model class for table "complect_lines".
 *
 * The followings are the available columns in table 'complect_lines':
 * @property integer $id
 * @property integer $complect_id
 * @property integer $asset_id
 * @property integer $amount
 */
class ComplectLine extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ComplectLine the static model class
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
		return 'complect_lines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('complect_id, asset_id, amount, asset_template_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, complect_id, asset_id, amount, asset_template_id', 'safe', 'on'=>'search'),
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
                    'complect' => array(self::BELONGS_TO, 'Complect', 'complect_id' ),
                    'asset' => array(self::BELONGS_TO, 'Asset', 'asset_id' ),
                    'assettemplate' => array(self::BELONGS_TO, 'AssetTemplate', 'asset_template_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'complect_id' => 'Complect',
			'asset_id' => 'Asset',
			'amount' => 'Amount',
                    'asset_template_id' => 'Asset Template'
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
		$criteria->compare('complect_id',$this->complect_id);
		$criteria->compare('asset_id',$this->asset_id);
                $criteria->compare('asset_template_id',  $this->asset_template_id);
		$criteria->compare('amount',$this->amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}