<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Mongo extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'SaleProduct';

}
