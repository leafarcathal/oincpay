<?php
namespace App\Traits;


trait ConstantTrait
{
    /**
     * @return array
     */
    static function getConstants() {
        $reflect = new \ReflectionClass(__CLASS__);
        return collect($reflect->getConstants());
    }

}