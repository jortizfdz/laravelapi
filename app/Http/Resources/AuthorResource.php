<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EditorialResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'=>$this->id,
          'name' => $this->name,
          'last_name' => $this->last_name,
          'email'=> $this->email,
          'phone'=>$this->phone,
          'editorial'=> new EditorialResource($this->whenLoaded('editorial')),
        ];
    }
}
