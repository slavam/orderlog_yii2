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
 * @property integer $price_type_id       !
 * @property string $comment              !
 * @property integer $asset_template_id   !
 * @property integer[] $place_id
 * @property integer[] $manufacturer_id
 * @property integer[] $product_id
 * @property integer[] $feature_id
 * @property integer $quantity_type_id
 * @property integer $quantity
 */
class Asset extends CActiveRecord
{
	public $selection;
	public $sel_man;
	public $sel_prod;
	public $sel_feat;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Asset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


        public function getDbConnection(){
	        return Yii::app()->db;
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
			array('ware_type_id, budget_item_id, direction_id, asset_group_id, unit_id, price_type_id', 'numerical', 'integerOnly'=>true),
//			array('selection', 'required'),
			array('cost', 'numerical'),
			array('name, part_number, info, comment,place_id, manufacturer_id, product_id, feature_id, place_id, manufacturer_id, product_id, feature_id, quantity_type_id, quantity', 'safe'),
			array('name, part_number, asset_template_id','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, part_number, ware_type_id, budget_item_id, cost, direction_id, asset_group_id, info, unit_id, comment, price_type_id, asset_template_id, place_id, manufacturer_id, product_id, feature_id, quantity_type_id, quantity', 'safe', 'on'=>'search'),
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
                    'assettemplate' => array(self::BELONGS_TO, 'AssetTemplate', 'asset_template_id' ),
		    'quantityType' => array(self::BELONGS_TO, 'QuantityTypes', 'quantity_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Наименование',
			'part_number' => 'Код',
			'ware_type_id' => 'Ware Type',
			'budget_item_id' => 'Budget Item',
			'cost' => 'Cost',
			'direction_id' => 'Direction',
			'asset_group_id' => 'Asset Group',
			'info' => 'Info',
                        'comment' => 'Comment',
			'unit_id' => 'Unit',
			'asset_template_id' => 'Шаблон товара',
			'place_id' => 'Расположение',
			'manufacturer_id' => 'Производитель',
			'product_id' => 'Продукты',
			'feature_id' => 'Характеристики',
			'quantity_type_id' => 'Тип количества',
			'quantity' => 'Количество',
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
                $criteria->compare('comment',$this->comment,true);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('place_id',$this->place_id);
		$criteria->compare('manufacturer_id',$this->manufacturer_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity_type_id',$this->quantity_type_id);
		$criteria->compare('quantity',$this->quantity);

		$criteria->together = true;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
/*        
        private function CheckSave($arr_for_check) {
                                
                $tmpcount = count($arr_for_check);
                
		if(count($arr_for_check) > 1) {
			$tmp_str = implode(',',$arr_for_check);
		} else {
			$tmp_str=$arr_for_check[0];
		}
       		$tmp_str = "{".$tmp_str."}";
           return $tmp_str;           
        }
*/
        
	public function afterFind() {
/*            
            if (isset($this->place_id)) {
                $this->place_id = trim($this->place_id,"{}");
		$this->selection = explode(',',$this->place_id);
            } else {
                $this->selection = NULL;
            }
 * 
 */
            if (isset($this->place_id)) {
                $this->place_id = trim($this->place_id,"{}");
            }

            if (isset($this->manufacturer_id)) {
                $this->manufacturer_id = trim($this->manufacturer_id,"{}");
            }
            
            if (isset($this->product_id)) {
                $this->product_id = trim($this->product_id,"{}");
            }

            if (isset($this->feature_id)) {
                $this->feature_id = trim($this->feature_id,"{}");
            }

	}
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
            
        if (isset($this->place_id)) {
           $this->place_id = "{".$this->place_id."}";
        } else {
           $this->place_id = NULL;            
        }     
  
        if (isset($this->manufacturer_id)) {
                $this->manufacturer_id = "{".$this->manufacturer_id."}";
        } else {
                $this->manufacturer_id = NULL;
        }
        
        if (isset($this->product_id)) {
                $this->product_id = "{".$this->product_id."}";
        } else {
                $this->product_id = NULL;
        }
        if (isset($this->feature_id)) {
                $this->feature_id = "{".$this->feature_id."}";
        } else {
                $this->feature_id = NULL;
        }

		return parent::beforeSave();
//       		return TRUE;

	}

        public function findAssets()
	{
       		$assets = Asset::model()->findAll(array('order' => 'name'));
		return CHtml::listData($assets,'id','name');
	}
/*
        public function get_price()
         {
//            $s = Yii::app()->createUrl("asset/updateGrid",array("id"=>$this->id));
//            return '<form action="http://127.0.0.1/demos/ordertest/index.php?r=asset/updateGrid&id='.$this->id .'" method="post">'.
            return '<form action="'.Yii::app()->createUrl("asset/updateGrid",array("id"=>$this->id)).'" method="post">'.
                   @CActiveForm::textField($this,"cost",array("name"=>"Asset[cost]")).
                   @CActiveForm::hiddenField($this,"id",array("id"=>"id_".$this->id)).
                   '</form>';
         }
*/
         public function findAssetsByTemplate($asset_template_id) {
		$criteria=new CDbCriteria;
                $criteria->condition="asset_template_id=".$asset_template_id;
                $criteria->order='name';
       		$assets = Asset::model()->findAll($criteria);
		return CHtml::listData($assets,'id','name');
         }
                 
}