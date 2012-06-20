<?php

/**
 * This is the model class for table "assets".
 *
 * The followings are the available columns in table 'assets':
 * @property integer $id
 * @property string $name
 * @property string $part_number
 * @property integer $ware_type_id
 * @property integer $budget_item_id
 * @property double $cost
 * @property integer $direction_id
 * @property integer $asset_group_id
 * @property string $info
 * @property integer $unit_id
 */
class Asset extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Asset the static model class
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
		return 'assets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ware_type_id, budget_item_id, direction_id, asset_group_id, unit_id', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('name, part_number, info', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, part_number, ware_type_id, budget_item_id, cost, direction_id, asset_group_id, info, unit_id', 'safe', 'on'=>'search'),
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
                    'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'part_number' => 'Part Number',
			'ware_type_id' => 'Ware Type',
			'budget_item_id' => 'Budget Item',
			'cost' => 'Cost',
			'direction_id' => 'Direction',
			'asset_group_id' => 'Asset Group',
			'info' => 'Info',
			'unit_id' => 'Unit',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('part_number',$this->part_number,true);
		$criteria->compare('ware_type_id',$this->ware_type_id);
		$criteria->compare('budget_item_id',$this->budget_item_id);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('direction_id',$this->direction_id);
		$criteria->compare('asset_group_id',$this->asset_group_id);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('unit_id',$this->unit_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}