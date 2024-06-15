<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Lecture\UpdateLectureArticleContentAction;
use App\Actions\Lecture\UploadChunkedVideoAction;
use App\Data\Lecture\LectureArticleContentData;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class InstructorLectureContentController extends Controller
{
    public function updateArticle(LectureArticleContentData $data, Course $course, Lecture $lecture)
    {
        $lecture = UpdateLectureArticleContentAction::run($data, $lecture);

        return LectureResource::make($lecture);
    }

    public function uploadVideo(Request $request, Lecture $lecture)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if (! $receiver->isUploaded()) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $chunks = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($chunks->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            $response = UploadChunkedVideoAction::run($lecture, $chunks->getFile());
            // delete the file
            try {
                unlink($chunks->getFile()->getPathname());
            } catch (\Exception $e) {
                // report any exception but continue handling the request
                report($e);

                return false;
            }

            return response()->json($response);
        }

        // we are in chunk mode, lets send the current progress
        $handler = $chunks->handler();

        return response()->json([
            'done' => $handler->getPercentageDone(),
            'status' => true,
        ]);
    }
}
