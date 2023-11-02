<?php

namespace App\Http\Traits;

trait AccessableTableName
{
    public static function tableName()
    {
        return with(new static())->getTable();
    }
}
