<?php
declare(strict_types=1);

namespace DocBrownLab\SeoFriendlyUrl\Block\Adminhtml\System\Config\Form\Field;

use DocBrownLab\SeoFriendlyUrl\Model\DefaultMappings;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Mappings extends AbstractFieldArray
{
    private const ROW_ID_PREFIX = '_';

    private DefaultMappings $defaultMappings;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        DefaultMappings $defaultMappings,
        array $data = []
    ) {
        $this->defaultMappings = $defaultMappings;
        parent::__construct($context, $data);
    }

    protected function _prepareToRender()
    {
        $this->addColumn(
            'character',
            [
                'label' => __('Original Character'),
                'class' => 'required-entry',
                'style' => 'width:140px'
            ]
        );
        $this->addColumn(
            'replacement',
            [
                'label' => __('Replacement'),
                'style' => 'width:180px'
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Conversion');
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $value = $element->getValue();

        if (!$value) {
            $value = $this->defaultMappings->getRows();
        }

        if (is_array($value)) {
            $element->setValue($this->normalizeRowIds($value));
        }

        return parent::_getElementHtml($element);
    }

    /**
     * @param array<mixed> $rows
     * @return array<string, array<string, string>>
     */
    private function normalizeRowIds(array $rows): array
    {
        $normalizedRows = [];

        foreach ($rows as $rowId => $row) {
            if (!is_array($row)) {
                continue;
            }

            $safeRowId = is_string($rowId) && str_starts_with($rowId, self::ROW_ID_PREFIX)
                ? $rowId
                : self::ROW_ID_PREFIX . md5((string)$rowId . serialize($row));

            $normalizedRows[$safeRowId] = $row;
        }

        return $normalizedRows;
    }
}
