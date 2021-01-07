<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Package extends Model
{
	use SoftDeletes;

    protected $collection = 'packages';

    protected $guarded = [];
}
