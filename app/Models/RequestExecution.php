<?php

namespace App\Models;

use App\Enums\HttpMethods;
use App\Models\Traits\EnumTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestExecution extends Model
{
    use HasFactory;
    use EnumTrait;

    const UPDATED_AT = null;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are enum.
     *
     * @return array
     */
    protected static function enumAttributes(): array
    {
        return [
            'method' => HttpMethods::getEnums()
        ];
    }
}
