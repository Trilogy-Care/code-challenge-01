<?php

namespace App\Http\Resources\Billing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'bill_reference' => $this->bill_reference,
            'bill_date' => $this->bill_date,
            'submitted_at' => $this->submitted_at?->toDateString(),
            'approved_at' => $this->approved_at?->toDateString(),
            'on_hold_at' => $this->on_hold_at?->toDateString(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'stage' => $this->whenLoaded('billStage', function () {
                return BillStageResource::make($this->billStage);
            })
        ];
    }
}
