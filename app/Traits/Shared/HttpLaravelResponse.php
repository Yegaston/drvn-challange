<?php

namespace App\Traits\Shared;

trait HttpLaravelResponse
{
    /**
     * Respond with a given item using laravel resources.
     *
     * @param $item
     * @param \Illuminate\Http\Resources\Json\JsonResource $jsonResource
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem($item, $jsonResource = null)
    {
        /** @var \Illuminate\Http\Resources\Json\JsonResource $resource */
        $resource = $this->item($item, $jsonResource);

        $resource->additional($this->metaItem($item));

        return $this->response($resource);
    }

    /**
     * Respond with a given collection using laravel resources.
     *
     * @param $collection
     * @param \Illuminate\Http\Resources\Json\JsonResource $jsonResource
     * @param array $sortFieldsAvailable
     * @return mixed
     */
    protected function respondWithCollection($collection, $jsonResource = null, $sortFieldsAvailable = [])
    {
        /** @var \Illuminate\Http\Resources\Json\ResourceCollection $resource */
        $resource = $this->collection($collection, $jsonResource);

        $resource->additional($this->metaCollection($collection, $sortFieldsAvailable));

        return $this->response($resource);
    }
}
