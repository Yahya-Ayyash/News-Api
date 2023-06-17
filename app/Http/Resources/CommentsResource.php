<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
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
            'id'               => $this->id,
            'comments_content' => $this->comments_content,
            'commentator'      => $this->commentator['name'],
            'created_at'       => date_format($this->created_at, "Y/m/d H:i")
        ];
    }
}
