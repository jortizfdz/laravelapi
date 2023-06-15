<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
          'exterior_number' => $this->exterior_number,
          'interior_number' => $this->interior_number,
          'zip'=> $this->zip,
          'street_name'=>$this->street_name,
          'reference'=> $this->reference,
        ];
    }
}
