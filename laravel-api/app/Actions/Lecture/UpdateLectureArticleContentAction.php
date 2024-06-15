<?php

namespace App\Actions\Lecture;

use App\Data\Lecture\LectureArticleContentData;
use App\Enums\LectureType;
use App\Models\Lecture;

class UpdateLectureArticleContentAction
{
    public static function run(LectureArticleContentData $data, Lecture $lecture)
    {
        $lecture->update([
            'body' => $data->body,
            'duration_minutes' => self::calculateArticleReadingTime($data->body),
            'type' => LectureType::TEXT,
        ]);

        // delete any video for this lecture if it exists
        if ($lecture->video()->exists()) {
            $lecture->video->delete();
        }

        return $lecture->refresh();
    }

    protected static function calculateArticleReadingTime($text)
    {
        $word_count = str_word_count(strip_tags($text));

        return round($word_count / 200, 2);
    }
}
