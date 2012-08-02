<?php

/**
 * This is the model class for table "asset_templates".
 *
 * The followings are the available columns in table 'asset_templates':
 * @property integer $id
 * @property string $name
 * @property integer $ware_type_id
 * @property integer $budget_item_id
 * @property double $cost
 * @property integer $direction_id
 * @property integer $asset_group_id
 * @property integer $asset_template_id
 * @property integer $unit_id
 * @property integer $price_type_id
 * @property string $info
 * @property string $comment
 * @property string $part_number
 */
class AssetTemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AssetTemplate the static model class
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
		return 'asset_templates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ware_type_id, budget_item_id, direction_id, asset_group_id, unit_id, price_type_id', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('name, info, comment, part_number', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, ware_type_id, budget_item_id, cost, direction_id, asset_group_id, unit_id, price_type_id, info, comment, part_number', 'safe', 'on'=>'search'),
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
                    'waretype' => array(self::BELONGS_TO, 'WareType', 'ware_type_id' ),
                    'assetgroup' => array(self::BELONGS_TO,'AssetGroup','asset_group_id'),
                    'budgetItem' => array(self::BELONGS_TO, 'BudgetItem', 'budget_item_id'),
                    'direction' => array(self::BELONGS_TO, 'Direction', 'direction_id'),
                    'priceType' => array(self::BELONGS_TO, 'PriceType', 'price_type_id'),
                    'block' => array(self::HAS_ONE, 'Block', array('block_id'=>'id'),'through'=>'assetgroup'),
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
			'ware_type_id' => 'Ware Type',
			'budget_item_id' => 'Budget Item',
			'cost' => 'Cost',
			'direction_id' => 'Direction',
			'asset_group_id' => 'Asset Group',
//			'asset_template_id' => 'Asset Template',
			'unit_id' => 'Unit',
			'price_type_id' => 'Price Type',
			'info' => 'Info',
			'comment' => 'Comment',
			'part_number' => 'Part Number',
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
		$criteria->compare('ware_type_id',$this->ware_type_id);
		$criteria->compare('budget_item_id',$this->budget_item_id);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('direction_id',$this->direction_id);
		$criteria->compare('asset_group_id',$this->asset_group_id);
//		$criteria->compare('asset_template_id',$this->asset_template_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('price_type_id',$this->price_type_id);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('part_number',$this->part_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function findAssetTemplates()
	{
       		$templates = AssetTemplate::model()->findAll(array('order' => 'name'));
		return CHtml::listData($templates,'id','name');
	}
}