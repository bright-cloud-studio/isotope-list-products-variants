<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Isotope List Products Variants
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/isotope-list-products-variants
 */

declare(strict_types=1);

namespace Bcs\IsotopeListProductsVariantsBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Routing\PageFinder;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Isotope\CoreBundle\Model\AttributeOptionModel;
use Isotope\CoreBundle\Model\ProductCategoryModel;
use Isotope\CoreBundle\Model\ProductModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement('show_variants', category: 'isotope', template: 'content_element/show_variants')]
class ShowVariantsController extends AbstractContentElementController
{
    private const MM_PER_INCH = 25.4;

    public function __construct(private readonly PageFinder $pageFinder)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        // Products are assigned to a page, not to this element, so the current page is the lookup key
        $page = $this->pageFinder->getCurrentPage($request);
        $types = array_map('intval', StringUtil::deserialize($model->iso_variant_product_types, true));

        if (null === $page || !$types) {
            return new Response('');
        }

        $products = $this->findProductsForPage((int) $page->id, $types);

        // Render nothing rather than an empty wrapper when the page has no products
        if (!$products) {
            return new Response('');
        }

        $variants = [];

        foreach (array_values($products) as $count => $product) {
            $variants[] = $this->buildVariant($product, $count);
        }

        $template->set('variants', $variants);
        $template->set('page_alias', $page->alias);
        $template->set('page_id', (int) $page->id);

        return $template->getResponse();
    }

    /**
     * Find the products of the configured types that are assigned to this page.
     *
     * Flow:
     *  1. Read the page's product assignments from tl_iso_product_category
     *  2. Load the published products of the configured types
     *  3. Restore the order the editor arranged, which the IN () query does not preserve
     *
     * @param array<int> $types
     *
     * @return array<ProductModel>
     */
    private function findProductsForPage(int $pageId, array $types): array
    {
        $categories = ProductCategoryModel::findBy(['pid=?'], [$pageId], ['order' => 'product_sorting']);

        if (null === $categories) {
            return [];
        }

        $ids = array_map('intval', $categories->fetchEach('product_id'));

        if (!$ids) {
            return [];
        }

        // The IDs are our own integers, so they are safe to inline; findBy() binds no lists
        $products = ProductModel::findBy(
            [
                'tl_iso_product.id IN ('.implode(',', $ids).')',
                'tl_iso_product.type IN ('.implode(',', $types).')',
                "tl_iso_product.published='1'",
            ],
            [],
        );

        if (null === $products) {
            return [];
        }

        $order = array_flip($ids);
        $models = $products->getModels();

        usort(
            $models,
            static fn (ProductModel $a, ProductModel $b) => ($order[(int) $a->id] ?? PHP_INT_MAX) <=> ($order[(int) $b->id] ?? PHP_INT_MAX),
        );

        return $models;
    }

    /**
     * Build the view data for one parent product and its child variants
     *
     * @return array<string, mixed>
     */
    private function buildVariant(ProductModel $product, int $count): array
    {
        $children = $this->findChildren((int) $product->id);

        // Build the size list from the child variants themselves, so it can never
        // fall out of sync with the products that actually exist
        $sizes = array_unique(array_filter(
            array_column($children, 'size'),
            static fn ($size) => '' !== trim((string) $size),
        ));

        return [
            'count' => $count,
            'id' => (int) $product->id,
            'name' => $product->name,
            'image' => $this->getFirstImagePath($product),
            'bristle' => $this->getOptionLabel($product->bristle_type),
            'children' => $children,
            'sizes' => $sizes ? implode(', ', $sizes) : (string) $product->wp_size,
        ];
    }

    /**
     * Load the published child variants, smallest first
     *
     * @return array<array<string, mixed>>
     */
    private function findChildren(int $productId): array
    {
        $children = ProductModel::findBy(
            ['pid=?', "published='1'"],
            [$productId],
            ['order' => 'width ASC, length ASC'],
        );

        if (null === $children) {
            return [];
        }

        $data = [];

        foreach ($children as $child) {
            $data[] = [
                'id' => (int) $child->id,
                'size' => $child->wp_size,
                'length' => round((float) $child->length, 2),
                'width' => round((float) $child->width, 2),
                'mm_length' => round((float) $child->length * self::MM_PER_INCH, 2),
                'mm_width' => round((float) $child->width * self::MM_PER_INCH, 2),
            ];
        }

        return $data;
    }

    /**
     * Resolve the first product image to a path the image studio can read.
     *
     * Isotope stores a bare file name and expands it to its own upload folder;
     * mirror that rule rather than guessing (see Isotope's Gallery\AbstractGallery).
     */
    private function getFirstImagePath(ProductModel $product): string|null
    {
        $images = StringUtil::deserialize($product->images, true);
        $src = $images[0]['src'] ?? null;

        if (!$src) {
            return null;
        }

        if (!str_contains($src, '/')) {
            $src = 'isotope/'.strtolower($src[0]).'/'.$src;
        }

        return $src;
    }

    /**
     * Attribute values are stored as option IDs; the label is what we render
     */
    private function getOptionLabel(mixed $optionId): string
    {
        if (!$optionId) {
            return '';
        }

        return (string) (AttributeOptionModel::findByPk($optionId)?->label ?? '');
    }
}
