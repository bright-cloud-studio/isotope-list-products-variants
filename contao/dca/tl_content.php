<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Isotope List Products Variants
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/isotope-list-products-variants
 */

declare(strict_types=1);

use Isotope\CoreBundle\Model\ProductTypeModel;

/** Table tl_content */

// Palettes
$GLOBALS['TL_DCA']['tl_content']['palettes']['show_variants'] = '{type_legend},type,headline,title;{config_legend},iso_variant_product_types;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},cssID';

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['iso_variant_product_types'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['iso_variant_product_types'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options_callback'        => static function ()
    {
        $arrOptions = array();
        $objTypes = ProductTypeModel::findAll(array('order'=>'name'));

        if (null !== $objTypes)
        {
            foreach ($objTypes as $objType)
            {
                $arrOptions[$objType->id] = $objType->name;
            }
        }

        return $arrOptions;
    },
    'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'clr'),
    'sql'                     => array('type'=>'blob', 'notnull'=>false)
);
