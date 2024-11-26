<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Traits\Shared\HttpError;
use App\Traits\Shared\HttpLaravelResponse;
use App\Traits\Shared\HttpMeta;
use App\Traits\Shared\HttpResource;
use App\Traits\Shared\HttpResponse;

/**
 * Class BaseController
 * @property $transformer
 * @property $fractal
 * @package App\Core
 */
abstract class BaseController extends Controller
{
    use HttpError, HttpResource, HttpLaravelResponse, HttpMeta, HttpResponse;

    /**
     * BaseController constructor.
     *
     * @return void
     */
    public function __construct() {}
}
