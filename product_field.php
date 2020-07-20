<?php
/**
 * After install clean prestashop cache
 */


if (!defined('_PS_VERSION_')) {
    exit;
}

class product_field extends Module
{
    // const CLASS_NAME = 'ps_customercedula';

    public function __construct()
    {
        $this->name = 'product_field';
        $this->version = '1.0.0';
        $this->author = 'ahmed';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->getTranslator()->trans(
            'Product field',
            [],
            'Modules.product_field.Admin'
        );

        $this->description =
            $this->getTranslator()->trans(
                'Product field list',
                [],
                'Modules.product_field.Admin'
            );

        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_,
        ];
    }
    /**
     * This function is required in order to make module compatible with new translation system.
     *
     * @return bool
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * Install module and register hooks to allow grid modification.
     *
     * @see https://devdocs.prestashop.com/1.7/modules/concepts/hooks/use-hooks-on-modern-pages/
     *
     * @return bool
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionAdminProductsListingFieldsModifier') 
         
        ;
    }

    public function uninstall()
    {
        return parent::uninstall() ;
    }



   public function hookActionAdminProductsListingFieldsModifier($params)
  {

      // Manufacturer
        $params['sql_select']['upc'] = [
            'table' => 'p',
            'field' => 'upc',
            'filtering' => \PrestaShop\PrestaShop\Adapter\Admin\AbstractAdminQueryBuilder::FILTERING_LIKE_BOTH
            ];

             $params['sql_select']['isbn'] = [
            'table' => 'p',
            'field' => 'isbn',
            'filtering' => \PrestaShop\PrestaShop\Adapter\Admin\AbstractAdminQueryBuilder::FILTERING_LIKE_BOTH
            ];

        
        
        $upcFilter = Tools::getValue('filter_column_upc',false);
        if ($upcFilter && $upcFilter !=  '') {
            $params['sql_where'][] .= " p.upc like '%".$upcFilter."%' ";
        }

        $isbnFilter = Tools::getValue('filter_column_isbn',false);
        if ($isbnFilter && $isbnFilter !=  '') {
            $params['sql_where'][] .= " p.isbn like '%".$isbnFilter."%' ";
        }


}
}