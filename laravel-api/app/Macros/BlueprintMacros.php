<?php

namespace App\Macros;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;

/**
 * @mixin Blueprint
 */
class BlueprintMacros
{
    public function primaryKey(): Closure
    {
        return function () {
//            /* @var $this Blueprint */
            $this->string('id');
            $this->primary('id');
        };
    }

    public function morphFields(): Closure
    {
        return function (string $name, string $indexName = null) {
            /* @var $this Blueprint */
            $this->string("{$name}_id");
            $this->string("{$name}_type");
            $this->index(["{$name}_id", "{$name}_type"], $indexName);
        };
    }

    public function nullableMorphFields(): Closure
    {
        return function (string $name, string $indexName = null) {
            /* @var $this Blueprint */
            $this->string("{$name}_id")->nullable();
            $this->string("{$name}_type")->nullable();
            $this->index(["{$name}_id", "{$name}_type"], $indexName);
        };
    }

    public function foreignKey(): Closure
    {
        return function (string $name) {
            /* @var $this Blueprint */
            $this->string("{$name}");

            return new ForeignIdColumnDefinition($this, [
                'type' => 'string',
                'name' => $name,
                'autoIncrement' => false,
                'unsigned' => false,
            ]);
        };
    }

    public function nullableForeignKey(): Closure
    {
        return function (string $name) {
            /* @var $this Blueprint */
            $this->string("{$name}")->nullable();

            return new ForeignIdColumnDefinition($this, [
                'type' => 'string',
                'name' => $name,
                'autoIncrement' => false,
                'unsigned' => false,
            ]);
        };
    }
}
