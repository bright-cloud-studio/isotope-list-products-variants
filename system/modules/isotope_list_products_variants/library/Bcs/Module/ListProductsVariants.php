<?php

/**
 * Bright Cloud Studio - Isotope List Products Variants
 *
 * Copyright (C) 2022 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/isotope-list-products-variants
 * @link       http://brightcloudstudio.com
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

  
namespace Bcs\Module;

use Isotope\Module\ProductList;


class ListProductVariants extends ProductList
{

	/**
     * Find all products we need to list.
     *
     * @param array|null $arrCacheIds
     *
     * @return array
     */
    protected function findProducts($arrCacheIds = null)
    {
        $arrColumns = array();
        $arrFilters = Isotope::getRequestCache()->getFiltersForModules($this->iso_filterModules);
        $arrCategories = $this->findCategories($arrFilters);
        $queryBuilder = new FilterQueryBuilder($arrFilters);

        $arrColumns[] = Product::getTable().'.pid=0';

        if (1 === \count($arrCategories)) {
            $arrColumns[] = "c.page_id=".reset($arrCategories);
        } else {
            $arrColumns[] = "c.page_id IN (".implode(',', $arrCategories).")";
        }

        if (!empty($arrCacheIds) && \is_array($arrCacheIds)) {
            $arrColumns[] = Product::getTable() . ".id IN (" . implode(',', $arrCacheIds) . ")";
        }

        // Apply new/old product filter
        if ('show_new' === $this->iso_newFilter) {
            $arrColumns[] = Product::getTable() . ".dateAdded>=" . Isotope::getConfig()->getNewProductLimit();
        } elseif ('show_old' === $this->iso_newFilter) {
            $arrColumns[] = Product::getTable() . ".dateAdded<" . Isotope::getConfig()->getNewProductLimit();
        }

        if ($this->iso_list_where != '') {
            $arrColumns[] = $this->iso_list_where;
        }

        if ($queryBuilder->hasSqlCondition()) {
            $arrColumns[] = $queryBuilder->getSqlWhere();
        }

        $arrSorting = Isotope::getRequestCache()->getSortingsForModules($this->iso_filterModules);

        if (empty($arrSorting) && $this->iso_listingSortField != '') {
            $direction = ('DESC' === $this->iso_listingSortDirection ? Sort::descending() : Sort::ascending());
            $arrSorting[$this->iso_listingSortField] = $direction;
        }

        $objProducts = Product::findAvailableBy(
            $arrColumns,
            $queryBuilder->getSqlValues(),
            array(
                 'order'   => 1 === \count($arrCategories) ? 'c.sorting' : null,
                 'filters' => $queryBuilder->getFilters(),
                 'sorting' => $arrSorting,
            )
        );

        return (null === $objProducts) ? array() : $objProducts->getModels();
    }

}
