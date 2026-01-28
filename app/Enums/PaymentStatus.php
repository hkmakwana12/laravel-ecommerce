<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING        = 'pending';
    case PARTIALPAID    = 'partial paid';
    case PAID           = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::PENDING       => 'Pending',
            self::PARTIALPAID   => 'Partial Paid',
            self::PAID          => 'Paid',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING      => 'error',
            self::PARTIALPAID  => 'gray',
            self::PAID         => 'success',
        };
    }

    public static function options(): array
    {
        return array_map(fn($type) => ['value' => $type->value, 'label' => $type->label()], self::cases());
    }
}
