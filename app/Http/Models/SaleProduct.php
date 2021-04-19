<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    //
    protected $table = 'sale_product';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['productname' ,'buyprice' ,'saleprice' ,'tranprice' ,'buydate' ,'saledate'];
}
