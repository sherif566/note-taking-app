<?php

namespace App\Config;

class PaginationConfig
{
    const DEFAULT_PAGE_SIZE = 10;

    public static function defaultSize(): int
    {
        return self::DEFAULT_PAGE_SIZE;
    }
}
