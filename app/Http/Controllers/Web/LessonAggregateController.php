<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\SyncLessonAggregateRequest;
use App\Models\Lesson;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

class LessonAggregateController extends Controller
{
    /**
     * @param Lesson $parentLesson
     * @return View
     */
    public function index(Lesson $parentLesson)
    {
        // all lessons owned by user
        $ownedLessons = $this->user()->ownedLessons;

        // lessons aggregated to current lesson
        $lessonAggregate = $parentLesson->lessonAggregate;

        $lessons = [];

        // check intersection between all lessons owned by user and aggregated lessons
        // mark aggregated lessons, so checkboxes are checked next to these on the UI
        foreach ($ownedLessons as &$ownedLesson) {

            // skip current lesson, impossible to aggregate itself
            if ($ownedLesson->id == $parentLesson->id) {
                continue;
            }

            $row = [];
            $row['id'] = $ownedLesson->id;
            $row['name'] = $ownedLesson->name;
            $row['is_aggregated'] = false;

            foreach ($lessonAggregate as $la) {
                if ($ownedLesson->id == $la->id) {
                    $row['is_aggregated'] = true;
                }
            }

            $lessons[] = $row;
        }

        return view('lessons.aggregate', [
            'lesson' => $parentLesson,
            'lessons' => $lessons,
        ]);
    }

    /**
     * @param Lesson                     $parentLesson
     * @param SyncLessonAggregateRequest $request
     * @return RedirectResponse
     */
    public function sync(Lesson $parentLesson, SyncLessonAggregateRequest $request)
    {
        $parentLesson->lessonAggregate()->sync($request->aggregates);

        return redirect('/lessons/aggregate/'.$parentLesson->id);
    }
}
