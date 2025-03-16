<?php

namespace App\Enums;

enum ExportType: int
{
    case EXCEL = 1;
    case CSV = 2;

    public function extension (): string
    {
        return match ($this) {
            self::EXCEL => '.xlsx',
            self::CSV => '.csv',
        };
    }

    public static function all()
    {
        return array_column(ExportType::cases(), 'value');
    }
}
