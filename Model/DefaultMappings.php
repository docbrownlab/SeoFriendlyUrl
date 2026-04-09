<?php
declare(strict_types=1);

namespace DocBrownLab\SeoFriendlyUrl\Model;

class DefaultMappings
{
    /**
     * @return array<int, array<string, string>>
     */
    public function getRows(): array
    {
        return [
            ['character' => 'à', 'replacement' => 'a'],
            ['character' => 'á', 'replacement' => 'a'],
            ['character' => 'â', 'replacement' => 'a'],
            ['character' => 'ã', 'replacement' => 'a'],
            ['character' => 'ä', 'replacement' => 'a'],
            ['character' => 'ç', 'replacement' => 'c'],
            ['character' => 'è', 'replacement' => 'e'],
            ['character' => 'é', 'replacement' => 'e'],
            ['character' => 'ê', 'replacement' => 'e'],
            ['character' => 'ë', 'replacement' => 'e'],
            ['character' => 'ì', 'replacement' => 'i'],
            ['character' => 'í', 'replacement' => 'i'],
            ['character' => 'î', 'replacement' => 'i'],
            ['character' => 'ï', 'replacement' => 'i'],
            ['character' => 'ñ', 'replacement' => 'n'],
            ['character' => 'ò', 'replacement' => 'o'],
            ['character' => 'ó', 'replacement' => 'o'],
            ['character' => 'ô', 'replacement' => 'o'],
            ['character' => 'õ', 'replacement' => 'o'],
            ['character' => 'ö', 'replacement' => 'o'],
            ['character' => 'ù', 'replacement' => 'u'],
            ['character' => 'ú', 'replacement' => 'u'],
            ['character' => 'û', 'replacement' => 'u'],
            ['character' => 'ü', 'replacement' => 'u'],
            ['character' => 'ý', 'replacement' => 'y'],
            ['character' => 'ÿ', 'replacement' => 'y'],
            ['character' => 'æ', 'replacement' => 'ae'],
            ['character' => 'œ', 'replacement' => 'oe'],
            ['character' => 'ß', 'replacement' => 'ss']
        ];
    }
}
