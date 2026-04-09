<?php
declare(strict_types=1);

namespace DocBrownLab\SeoFriendlyUrl\Plugin\Catalog\Model\Product;

use DocBrownLab\SeoFriendlyUrl\Model\Config;
use DocBrownLab\SeoFriendlyUrl\Model\SlugSanitizer;
use Magento\Catalog\Model\Product;

class FormatUrlKeyPlugin
{
    private Config $config;

    private SlugSanitizer $slugSanitizer;

    public function __construct(
        Config $config,
        SlugSanitizer $slugSanitizer
    ) {
        $this->config = $config;
        $this->slugSanitizer = $slugSanitizer;
    }

    public function aroundFormatUrlKey(Product $subject, callable $proceed, $str): string
    {
        $storeId = $subject->getStoreId() !== null ? (int)$subject->getStoreId() : null;

        if (!$this->config->isEnabled($storeId)) {
            return $proceed($str);
        }

        return $proceed($this->slugSanitizer->sanitize((string)$str, $storeId));
    }
}
