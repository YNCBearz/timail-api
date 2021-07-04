<?php

namespace App\Models;

use App\Models\Traits\EnumTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestExecution extends Model
{
    use HasFactory;
    use EnumTrait;

    const UPDATED_AT = null;

    /**
     * The attributes that are enum.
     *
     * @var array
     */
    protected static array $enumAttributes = [
        'method' => self::METHOD
    ];

    /**
     * @var array
     */
    const METHOD = [
        'POST' => 1,
        'GET' => 2,
        'PATCH' => 3,
        'DELETE' => 4,
        'PUT' => 5
    ];
}
