<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestExecution extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

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

    /**
     * @param string $value
     */
    public function setMethodAttribute(string $value)
    {
        $this->attributes['method'] = self::METHOD[$value];
    }

    /**
     * @param int $value
     * @return string
     */
    public function getMethodAttribute(int $value): string
    {
        $flipped = array_flip(self::METHOD);
        return $flipped[$value];
    }
}
