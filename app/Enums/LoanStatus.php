<?php

namespace App\Enums;

enum LoanStatus: string
{
    case Active = 'active';
    case Overdue = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Overdue => 'Overdue',
        };
    }

    public function badgeContext(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Overdue => 'danger',
        };
    }

    public static function options(): array
    {
        return [
            self::Active->value => self::Active->label(),
            self::Overdue->value => self::Overdue->label(),
        ];
    }
}
