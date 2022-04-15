<?php

namespace App\Common\Repository;

use Exception;

interface PaginableContract
{
    public const FIELD_TOTAL = 'total';

    public const FIELD_LAST_PAGE = 'last_page';

    public const FIELD_PER_PAGE = 'per_page';

    public const FIELD_CURRENT_PAGE = 'current_page';

    public const FIELD_FILTERS = 'filters';

    public const FIELD_ITEMS = 'items';

    public const DEFAULT_PAGE = 1;

    public const DEFAULT_PER_PAGE = 10;

    public const REQUEST_RULES = [
        self::FIELD_FILTERS => [
            'nullable',
            'array',
        ],
        self::FIELD_PER_PAGE => [
            'nullable',
            'integer',
            'min:1',
        ],
        self::FIELD_CURRENT_PAGE => [
            'nullable',
            'integer',
            'min:1',
        ],
    ];

    /**
     * @param array $filter
     *
     * @return array
     * @throws Exception
     */
    public function paginate(array $filter = []): array;
}
