<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'student_name' => $this->student_name,
            'roll_no' => $this->roll_no,
            'photo' => asset($this->photo),
            'class' => $this->class,
            'total_score' => $this->scores_sum_score ?? 0,
        ];
    }
}
