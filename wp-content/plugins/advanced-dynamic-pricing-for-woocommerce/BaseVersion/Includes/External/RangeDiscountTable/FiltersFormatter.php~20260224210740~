<?php

namespace ADP\BaseVersion\Includes\External\RangeDiscountTable;

use ADP\BaseVersion\Includes\Common\Helpers;
use ADP\BaseVersion\Includes\Rule\Structures\Filter;
use ADP\BaseVersion\Includes\Rule\Structures\SingleItemRule;

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class FiltersFormatter
{
    protected $textDomain = 'advanced-dynamic-pricing-for-woocommerce';

    public function __construct()
    {
    }

    /**
     * @param Filter $filter
     *
     * @return string
     */
    public function formatFilter($filter)
    {
        $filterType   = $filter->getType();
        $filter_method = $filter->getMethod();

        $filterQtyLabel = '1';

        if ($filter::TYPE_ANY === $filterType) {
            return sprintf('<a href="%s">%s</a>', get_permalink(wc_get_page_id('shop')),
                sprintf(__('%s of any product(s)', $this->textDomain), $filterQtyLabel));
        }

        $templates = array_merge(array(
            'products' => array(
                'in_list'     => __('%s product(s) from list: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) not from list: %s', $this->textDomain),
            ),

            'product_sku' => array(
                'in_list'     => __('%s product(s) with SKUs from list: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) with SKUs not from list: %s', $this->textDomain),
            ),

            'product_sellers' => array(
                'in_list'     => __('%s product(s) from sellers: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) not from sellers: %s', $this->textDomain),
            ),

            'product_categories' => array(
                'in_list'     => __('%s product(s) from categories: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) not from categories: %s', $this->textDomain),
            ),

            'product_category_slug' => array(
                'in_list'     => __('%s product(s) from categories with slug: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) not from categories with slug: %s', $this->textDomain),
            ),

            'product_tags' => array(
                'in_list'     => __('%s product(s) with tags from list: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) with tags not from list: %s', $this->textDomain),
            ),

            'product_attributes' => array(
                'in_list'     => __('%s product(s) with attributes from list: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) with attributes not from list: %s', $this->textDomain),
            ),

            'product_custom_fields' => array(
                'in_list'     => __('%s product(s) with custom fields: %s', $this->textDomain),
                'not_in_list' => __('%s product(s) without custom fields: %s', $this->textDomain),
            ),
        ), array_combine(array_keys(Helpers::getCustomProductTaxonomies()),
            array_map(function ($tmpFilterType) {
                return array(
                    'in_list'     => __('%s product(s) with ' . $tmpFilterType . ' from list: %s',
                        $this->textDomain),
                    'not_in_list' => __('%s product(s) with ' . $tmpFilterType . ' not from list: %s',
                        $this->textDomain),
                );
            }, array_keys(Helpers::getCustomProductTaxonomies()))));

        if ( ! isset($templates[$filterType][$filter_method])) {
            return "";
        }

        $humanizedValues = array();
        foreach ($filter->getValue() as $id) {
            $name = Helpers::getTitleByType($id, $filterType);
            $link = Helpers::getPermalinkByType($id, $filterType);

            if ( ! empty($link)) {
                $humanized_value = "<a href='{$link}'>{$name}</a>";
            } else {
                $humanized_value = "'{$name}'";
            }

            $humanizedValues[$id] = $humanized_value;
        }

        return sprintf($templates[$filterType][$filter_method], $filterQtyLabel, implode(", ", $humanizedValues));
    }

    /**
     * @param SingleItemRule $rule
     *
     * @return array
     */
    public function formatRule(SingleItemRule $rule)
    {
        $humanizedFilters = array();

        foreach ($rule->getFilters() as $filter) {
            $humanizedFilters[] = $this->formatFilter($filter);
        }

        return $humanizedFilters;
    }
}
