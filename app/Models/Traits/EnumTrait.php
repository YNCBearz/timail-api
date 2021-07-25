<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Str;

/**
 * Trait EnumTrait for Eloquent accessors & mutators.
 *
 * 1. Define static function enumAttributes() in Model.
 * 2. Define enum of each attribute.
 * 3. Use EnumTrait in Model class.
 */
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
        if ($this->isEnumAttributes($key)) {
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
        if ($this->isEnumAttributes($key)) {
            return $this->setMutatedAttributeValueByEnum($key, $value);
        }

        return $this->{'set'.Str::studly($key).'Attribute'}($value);
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function isEnumAttributes(string $key): bool
    {
        return array_key_exists($key, self::enumAttributes());
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    private function setMutatedAttributeValueByEnum($key, $value)
    {
        $enum = $this->enumByKey($key);
        return $this->attributes[$key] = $enum[$value];
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
        if ($this->isEnumAttributes($key)) {
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
        if ($this->isEnumAttributes($key)) {
            return $this->mutateAttributeByEnum($key, $value);
        }

        return $this->{'get'.Str::studly($key).'Attribute'}($value);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    private function mutateAttributeByEnum($key, $value)
    {
        $enum = $this->enumByKey($key);

        $flipped = array_flip($enum);
        return $flipped[$value];
    }

    /**
     * @param string $key
     * @return array|int[]|mixed
     */
    private function enumByKey(string $key)
    {
        return self::enumAttributes()[$key];
    }
}
