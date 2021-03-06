<?php

namespace App\Http\Resources;

use App\Http\Resources\PageResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (get_class($this->resource) === 'Illuminate\Pagination\LengthAwarePaginator') {
            return [
                'data' => PageResource::collection($this->collection),
                'meta' => [
                    'count' => $this->count(),
                    'current_page' => $this->currentPage(),
                    'first_item' => $this->firstItem(),
                    'has_more_pages' => $this->hasMorePages(),
                    'last_item' => $this->lastItem(),
                    'last_page' => $this->lastPage(),
                    'per_page' => (int) $this->perPage(),
                    'total' => $this->total(),
                ],
            ];
        }
        return PageResource::collection($this->collection);
    }
}
