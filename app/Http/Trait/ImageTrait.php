<?php

namespace App\Http\Trait;

trait ImageTrait
{
    public function storimage($image)
    {
        $photo = $image->getClientOriginalExtension();
        $path = 'ExpertsImages';
        $photo_name = 'public/ExpertsImages'.'/'.time().'.'.$photo;
        $image->move($path, $photo_name);
        return $photo_name;
    }
}
