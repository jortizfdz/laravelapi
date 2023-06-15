<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EditorialResource;
use App\Http\Resources\AuthorResource;

class BookResource extends JsonResource
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
          'description' => $this->description,
          'page_numbers'=> $this->page_numbers,
          'editorial'=> new EditorialResource($this->whenLoaded('editorial')),
          'author'=> new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
