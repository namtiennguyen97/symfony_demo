<?php

/**
 * BaseCustomerCategoryAffiliate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $category_id
 * @property integer $affiliate_id
 * @property CustomerCategory $CustomerCategory
 * @property CustomerAffiliate $CustomerAffiliate
 * 
 * @method integer                   getCategory_id()       Returns the current record's "category_id" value
 * @method integer                   getAffiliAte_id()      Returns the current record's "affiliate_id" value
 * @method CustomerCategory          getCustomerCategory()  Returns the current record's "CustomerCategory" value
 * @method CustomerAffiliate         getCustomerAffiliate() Returns the current record's "CustomerAffiliate" value
 * @method CustomerCategoryAffiliate setCategory_id()       Sets the current record's "category_id" value
 * @method CustomerCategoryAffiliate setAffiliAte_id()      Sets the current record's "affiliate_id" value
 * @method CustomerCategoryAffiliate setCustomerCategory()  Sets the current record's "CustomerCategory" value
 * @method CustomerCategoryAffiliate setCustomerAffiliate() Sets the current record's "CustomerAffiliate" value
 * 
 * @package    tts_nam
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCustomerCategoryAffiliate extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('customer_category_affiliate');
        $this->hasColumn('category_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('affiliate_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CustomerCategory', array(
             'local' => 'category_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('CustomerAffiliate', array(
             'local' => 'affiliate_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}