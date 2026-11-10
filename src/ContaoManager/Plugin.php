<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Isotope List Products Variants
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/isotope-list-products-variants
 */

declare(strict_types=1);

namespace Bcs\IsotopeListProductsVariantsBundle\ContaoManager;

use Bcs\IsotopeListProductsVariantsBundle\BcsIsotopeListProductsVariantsBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Isotope\CoreBundle\IsotopeBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(BcsIsotopeListProductsVariantsBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, IsotopeBundle::class]),
        ];
    }
}
