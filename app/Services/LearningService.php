<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\ExerciseResult;
use App\Models\Lesson;
use Exception;

class LearningService
{
    /**
     * Fetch pseudo random exercise of lesson
     *
     * Exercise that user knows less have more chance to be returned.
     * Exercise that user knows more have less chance to be returned.
     *
     * @param Lesson   $lesson
     * @param int      $userId
     * @param int|null $previousExerciseId
     * @return Exercise|null
     * @throws Exception
     */
    public function fetchRandomExerciseOfLesson(Lesson $lesson, int $userId, int $previousExerciseId = null): ?Exercise
    {
        $exercises = $lesson->exercisesForGivenUser($userId)
            ->filter(function (Exercise $exercise) use ($previousExerciseId) {
                return $exercise->id != $previousExerciseId;
            });

        if ($exercises->isEmpty()) {
            return null;
        }

        if ($exercises->count() == 1) {
            return $exercises->first();
        }

        // if lesson is bidirectional
        // clone each exercise with reversed question and answer
        // so both variants are in the collection
        if ($lesson->isBidirectional($userId)) {
            foreach ($exercises as $exercise) {
                $clonedExercise = clone $exercise;
                $clonedExercise->question = $exercise->answer;
                $clonedExercise->answer = $exercise->question;
                $exercises->add($clonedExercise);
            }
        }

        $tmp = [];
        foreach ($exercises as $exercise) {
            /** @var ExerciseResult $result */
            $result = $exercise->results->where('user_id', '=', $userId)->first();

            // User needs this exercise if his percent_of_good_answers is below the threshold
            if ($result instanceof ExerciseResult) {
                // Check percent of good answers of a user
                $percentOfGoodAnswers = $result->percent_of_good_answers;
            } else {
                // User has no answers for this exercise, so we know that percent of good answers is 0
                $percentOfGoodAnswers = 0;
            }

            /*
             * Fill $tmp array with $exercises multiplied by number of points.
             *
             * This way exercises with higher number of points (so lower user knowledge),
             * will have bigger chance to be returned.
             */
            for ($i = $this->calculateNumberOfPoints($percentOfGoodAnswers); $i > 0; $i--) {
                $tmp[] = $exercise;
            }
        }

        // do randomization
        shuffle($tmp);
        return $tmp[array_rand($tmp)];
    }

    /**
     * @param int $percentOfGoodAnswers
     * @return int
     * @throws \Exception
     */
    private function calculateNumberOfPoints(int $percentOfGoodAnswers): int
    {
        if ($percentOfGoodAnswers == 100) {
            return 1;
        }

        return 100 - $percentOfGoodAnswers;
    }
}
