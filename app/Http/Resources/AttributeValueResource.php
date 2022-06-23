<?php

namespace App\Http\Resources;
use App\Models\News;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ProductAttributeValue
 */
class AttributeValueResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
