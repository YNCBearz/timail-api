<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Str;

trait EnumTrait
{
    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     *
     * @see HasAttributes::hasSetMutator()
     */
    public function hasSetMutator($key)
    {
        if ($this->isEnumsAttributes($key)) {
            return true;
        }

        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }

    /**
     * Set the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     *
     * @see HasAttributes::setMutatedAttributeValue()
     */
    protected function setMutatedAttributeValue($key, $value)
    {
        if ($this->isEnumsAttributes($key)) {
            return $this->setMutatedAttributeValueByEnums($key, $value);
        }

        return $this->{'set'.Str::studly($key).'Attribute'}($value);
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function isEnumsAttributes(string $key): bool
    {
        return array_key_exists($key, self::$enums);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    private function setMutatedAttributeValueByEnums($key, $value)
    {
        $lookup = self::$enums[$key];
        return $this->attributes[$key] = $lookup[$value];
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     *
     * @see HasAttributes::hasGetMutator()
     */
    public function hasGetMutator($key)
    {
        if ($this->isEnumsAttributes($key)) {
            return true;
        }

        return method_exists($this, 'get'.Str::studly($key).'Attribute');
    }

    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     *
     * @see HasAttributes::mutateAttribute()
     */
    protected function mutateAttribute($key, $value)
    {
        if ($this->isEnumsAttributes($key)) {
            return $this->mutateAttributeByEnums($key, $value);
        }

        return $this->{'get'.Str::studly($key).'Attribute'}($value);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    private function mutateAttributeByEnums($key, $value)
    {
        $lookup = self::$enums[$key];

        $flipped = array_flip($lookup);
        return $flipped[$value];
    }
}
