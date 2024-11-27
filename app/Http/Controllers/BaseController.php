<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Traits\Shared\HttpError;
use App\Traits\Shared\HttpLaravelResponse;
use App\Traits\Shared\HttpMeta;
use App\Traits\Shared\HttpResource;
use App\Traits\Shared\HttpResponse;
use Illuminate\Database\Eloquent\Model;

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


    protected function isOwner(int $userId, Model $model): bool
    {
        if ($userId === $model->created_by) {
            return true;
        }

        return $this->respondWithError('You are not authorized to perform this action');
    }
}
