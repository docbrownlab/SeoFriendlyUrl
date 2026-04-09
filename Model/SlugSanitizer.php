<?php
declare(strict_types=1);

namespace DocBrownLab\SeoFriendlyUrl\Model;

class SlugSanitizer
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function sanitize(string $value, ?int $storeId = null): string
    {
        $mappings = $this->config->getMappings($storeId);

        if ($mappings === []) {
            return $value;
        }

        return strtr($value, $mappings);
    }
}
