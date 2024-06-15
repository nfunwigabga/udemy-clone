<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'id' => $this->hashid,
            'code' => $this->code,
            'percent' => $this->percent,
            'quantity' => $this->quantity,
            'expired' => $this->expired(),
            'expires_at' => $this->expires_at?->format('d M, Y'),
            'active' => $this->active,
            'valid' => $this->isValid(),
            'link' => "?couponCode={$this->code}",
        ];
    }
}
