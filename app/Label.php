<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Label extends Eloquent 
{
    protected $connection = 'mongodb';
    protected $collection = 'labels';
    protected $primaryKey = '_id';
}
