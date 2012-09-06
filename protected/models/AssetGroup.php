<?php

/**
 * This is the model class for table "asset_groups".
 *
 * The followings are the available columns in table 'asset_groups':
 * @property integer $id
 * @property string $name
 * @property integer $block_id
 */
class AssetGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AssetGroup the static model class
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
		return 'asset_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('block_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, block_id', 'safe', 'on'=>'search'),
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
                    'assets' => array(self::HAS_MANY, 'Asset', 'asset_group_id'),
//                    'asset' => array(self::HAS_ONE, 'Asset', 'asset_group_id'),
                    'block' => array(self::BELONGS_TO, 'Block', 'block_id'),
                    
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
			'block_id' => 'Block',
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
		$criteria->compare('block_id',$this->block_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function findAssetGroups()
	{
       		$assetGroups = AssetGroup::model()->findAll(array('order' => 'name'));
		return CHtml::listData($assetGroups,'id','name');
	}

        public function findAssetGroupsByDirection($dir)
	{
	//TODO!!!
       		$assetGroups = AssetGroup::model()->findAllBySql("SELECT 
                    asset_groups.id, asset_groups.name
                    FROM 
                    asset_groups
                    JOIN blocks on asset_groups.block_id = blocks.id

                    WHERE blocks.direction_id=:dir ORDER BY asset_groups.name", array('dir'=>$dir)
                        );
                
		return $assetGroups;

	}

	//o.lysenko 6.sep.2012 15:06
	public function getGroupSubgroupStrings()
	{
		
		$crit  = new CDbCriteria();
		$crit->with=array('block');
                $crit->order='block.name, t.id';
		$model = AssetGroup::model()->findAll($crit);
                foreach ($model as $key => $value) {
                    $model[$key]->name=$model[$key]->block->name.' => '.$model[$key]->name;
                }
        return $model;   
	}
}