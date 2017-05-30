<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Campaign extends Eloquent 
{
    protected $connection = 'mongodb';
    protected $collection = 'campaigns';
    protected $primaryKey = '_id';
}
