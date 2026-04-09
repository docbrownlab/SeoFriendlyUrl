<?php
declare(strict_types=1);

namespace DocBrownLab\SeoFriendlyUrl\Model\Config\Backend;

use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;

class Mappings extends ArraySerialized
{
    private const ROW_ID_PREFIX = '_';

    public function beforeSave()
    {
        $value = $this->getValue();

        if (!is_array($value)) {
            $this->setValue([]);

            return parent::beforeSave();
        }

        unset($value['__empty']);

        $sanitizedRows = [];

        foreach ($value as $rowId => $row) {
            if (!is_array($row)) {
                continue;
            }

            $character = isset($row['character']) ? trim((string)$row['character']) : '';
            $replacement = isset($row['replacement']) ? trim((string)$row['replacement']) : '';

            if ($character === '') {
                continue;
            }

            $safeRowId = is_string($rowId) && str_starts_with($rowId, self::ROW_ID_PREFIX)
                ? $rowId
                : self::ROW_ID_PREFIX . md5((string)$rowId . $character . $replacement);

            $sanitizedRows[$safeRowId] = [
                'character' => $character,
                'replacement' => $replacement,
            ];
        }

        $this->setValue($sanitizedRows);

        return parent::beforeSave();
    }
}
