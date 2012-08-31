<?php

class Reference extends EMongoDocument {
    
    public $name;
    public $items;
    public $caption;
    
    public function getCollectionName() {
        return 'references';
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    
    function rules()
    {
        return array(
            array('name,items,caption','safe'),
        );
    }

    function search($caseSensitive = false) {
        $criteria = new EMongoCriteria;
         if ($_REQUEST['action']=='sub')
            {
                $criteria->addCond('_id', '==', new MongoId($_REQUEST['id']));
            }
        
        return new EMongoDocumentDataProvider('reference',
        array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 50),
        //'sort'=>$sort,
        //                                'sort' => array(
        //                                    'defaultOrder' => 'doc_date asc',
        //                                    'attributes' => array(
        //                                        'dog_number' => array('asc' => 'attrs.dog_number asc', 'desc' => 'attrs.dog_number desc'),
        //                                        'okpo' => array('asc' => 'attrs.okpo', 'desc' => 'attrs.okpo desc'),
        //                                        'provider' => array('asc' => 'attrs.provider', 'desc' => 'attrs.provider desc'),
        //                                        'start_date' => array('asc' => 'attrs.start_date', 'desc' => 'attrs.start_date desc')
        //                                    ),
        //                                ),
        //                            )
        )
    );

      //parent::search($caseSensitive);
    }
    
     static function getReference($id=null)
    {
        if ($id)
        {
            $reference = self::model()->findByPk(new MongoId($id));
            
            foreach ($reference->items as $key=>$item)
            {
                $items[$id.'='.$key]=$item['name'];
            }
            return $items;
        }
        else return array();
    }
    
    static function getReferenceByName($name=null)
    {
        if ($name)
        {
            $reference = self::model()->findByAttributes(array('name'=>$name));
           if ($reference)
           {
            foreach ($reference->items as $key=>$item)
            {
                $items[$reference->_id.'='.$key]=$item['name'];
            }
            return $items;
           }
           else return array();
        }
        else return array();
    }
    
    static function setReferenceToGridSearch($reference)
    {
        if (!isset($reference))
        {
            return false;
        }
        else
        {
            $result=array();
            foreach($reference as $key=>$value)
            {
                $result[]=$key.':'.$value;
            }
            $result=implode(';',$result);
        }
        return $result;
    }


    function getAllReferences()
{
    if (count($reference = self::model()->findAll())>0)
    {
        foreach ($reference as $key=>$item)
        {
            $items['Reference::getReference='.$item->_id]=$item->caption;
        }
        return $items;

    } else return array();
}
    
    function getReferenceItemById($id,$resType=null)
    {
        if ($id){
            $data = explode('=', $id);
            $reference =$this->getReference($data[0]);
            if (count($reference)>0)
            {
                switch ($resType){
                    case 'id': 
                        return $id;
                    default:
                        return $reference[$id];
                }
            }
        }
        return null;
    }

}

?>
