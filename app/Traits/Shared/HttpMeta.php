<?php

namespace App\Traits\Shared;

use App\Models\Shared\BaseModel;

trait HttpMeta
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $item
     * @return array
     */
    protected function metaItem($item): array
    {
        return [
            'meta' => [
                'allowed_includes' => $this->getProperty($item, 'allowed_includes'),
                'default_includes' => $this->getProperty($item, 'default_includes'),
            ]
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $collection
     * @param array $sortFields
     * @return array
     */
    protected function metaCollection($collection, $sortFields): array
    {
        return [
            'meta' => [
                'allowed_filters' => $this->getProperty($collection, 'allowed_filters', true),
                'allowed_sorts' => $this->getProperty($collection, 'allowed_sorts', true),
                'allowed_appends' => $this->getProperty($collection, 'allowed_appends'),
                'allowed_includes' => $this->getProperty($collection, 'allowed_includes'),
                'default_includes' => $this->getProperty($collection, 'default_includes'),
            ]
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $collection
     * @param array $sortFields
     * @return array
     */
    protected function getAllowedSortFields($collection, $sortFields = []): array
    {
        return $sortFields = !empty($sortFields)
            ? $sortFields
            : ($collection->count() > 0 ? ($collection->first()->allowed_sorts ?? []) : []);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator $resource
     * @param string $property
     * @param bool $key
     * @return array
     */
    protected function getProperty($resource, $property = '', bool $key = false): array
    {
        if (
            $resource instanceof \Illuminate\Database\Eloquent\Collection ||
            $resource instanceof \Illuminate\Pagination\LengthAwarePaginator
        ) {
            return $resource->count() > 0 ?
                $this->getProperty($resource->first(), $property, $key) : [];
        }

        return
            $resource instanceof \App\Models\Shared\BaseModel ||
            $resource instanceof \Illuminate\Http\Resources\Json\JsonResource ?
            $this->arrPluck($resource->$property, $key) : [];
    }

    /**
     * @param array $props
     * @param bool $key
     * @return array
     */
    protected function arrPluck($props, bool $key = false)
    {
        if ($key) {
            return array_values(collect($props)->map(function ($key, $value) {
                return is_string($value) ? $value : $key;
            })->all());
        }
        return $props ?? [];
    }
}
