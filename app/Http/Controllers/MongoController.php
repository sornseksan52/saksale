<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Mongo;
use DB;

class MongoController extends Controller
{
    public function create(Request $request)
    {
        try {
            echo '<pre>';
            print_r(DB::connection('mongodb')->getMongoClient()->listDatabases());

        } catch (\Exception $e) {
            echo $e->getMessage();
        }


    }
}
