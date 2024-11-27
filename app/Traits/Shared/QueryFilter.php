<?php

namespace App\Traits\Shared;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait QueryFilter
{
    /**
     * The sort available attributes.
     *
     * @var array
     */
    public $allowed_sorts = [];

    /**
     * The default includes for the model
     *
     * @var array
     */
    public $default_includes = [];

    /**
     * The available includes for the model
     *
     * @var array
     */
    public $allowed_includes = [];

    /**
     * The allowed filters for the model
     *
     * @var array
     */
    public $allowed_filters = [];
}
