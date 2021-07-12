<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginateResource extends ResourceCollection
{

    private $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            "current_page" => $resource->currentPage(),
            "last_page" => $resource->lastPage(),
            "total" => $resource->total() ,
            "from" => $resource->firstItem(),
            "to" => $resource->lastItem(),
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            $this->pagination
        ];
    }


}
