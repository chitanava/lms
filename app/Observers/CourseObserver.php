<?php

namespace App\Observers;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseObserver
{
    public function deleted(Course $course): void
    {
        if (!is_null($course->image)) {
            Storage::disk('public')->delete($course->image);
        }
    }
}
