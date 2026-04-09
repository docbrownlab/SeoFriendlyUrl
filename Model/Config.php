<?php
declare(strict_types=1);

namespace DocBrownLab\SeoFriendlyUrl\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const XML_PATH_ENABLED = 'docbrownlab_seofriendlyurl/general/enabled';
    public const XML_PATH_MAPPINGS = 'docbrownlab_seofriendlyurl/general/mappings';

    private ScopeConfigInterface $scopeConfig;

    private Json $serializer;

    private DefaultMappings $defaultMappings;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Json $serializer,
        DefaultMappings $defaultMappings
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
        $this->defaultMappings = $defaultMappings;
    }

    public function isEnabled(?int $storeId = null): bool
    {
        $storeId = $this->normalizeStoreId($storeId);

        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            $storeId === null ? ScopeConfigInterface::SCOPE_TYPE_DEFAULT : ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return array<string, string>
     */
    public function getMappings(?int $storeId = null): array
    {
        $storeId = $this->normalizeStoreId($storeId);

        $rows = $this->normalizeRows(
            $this->scopeConfig->getValue(
                self::XML_PATH_MAPPINGS,
                $storeId === null ? ScopeConfigInterface::SCOPE_TYPE_DEFAULT : ScopeInterface::SCOPE_STORE,
                $storeId
            )
        );

        if ($rows === null) {
            $rows = $this->defaultMappings->getRows();
        }

        $result = [];

        foreach ($rows as $row) {
            $character = isset($row['character']) ? trim((string)$row['character']) : '';
            $replacement = isset($row['replacement']) ? trim((string)$row['replacement']) : '';

            if ($character === '') {
                continue;
            }

            $result[$character] = $replacement;
            $this->appendCaseVariant($result, $character, $replacement);
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @return array<int, array<string, string>>|null
     */
    private function normalizeRows($value): ?array
    {
        if ($value === null || $value === '' || $value === false) {
            return null;
        }

        if (is_string($value)) {
            $value = trim($value);

            if ($value === '') {
                return null;
            }

            try {
                $value = $this->serializer->unserialize($value);
            } catch (\InvalidArgumentException $exception) {
                return null;
            }
        }

        if (!is_array($value)) {
            return null;
        }

        $rows = [];

        foreach ($value as $row) {
            if (!is_array($row)) {
                continue;
            }

            $rows[] = [
                'character' => isset($row['character']) ? (string)$row['character'] : '',
                'replacement' => isset($row['replacement']) ? (string)$row['replacement'] : '',
            ];
        }

        return $rows;
    }

    /**
     * Adds an uppercase variation so one row can normalize lower and upper case input.
     *
     * @param array<string, string> $mappings
     */
    private function appendCaseVariant(array &$mappings, string $character, string $replacement): void
    {
        $upperCharacter = mb_strtoupper($character, 'UTF-8');

        if ($upperCharacter === $character || isset($mappings[$upperCharacter])) {
            return;
        }

        $mappings[$upperCharacter] = $replacement;
    }

    private function normalizeStoreId(?int $storeId): ?int
    {
        if ($storeId === null || $storeId <= 0) {
            return null;
        }

        return $storeId;
    }
}
