<?php

namespace App\Jobs;

use App\Content;
use App\Chapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CopyCourseContent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $courseId;
    protected $newChapterId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($course_id, $chapter_id)
    {
        $this->courseId = $course_id;
        $this->newChapterId = $chapter_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Starting job for courseId: ".$this->courseId.", newChapterId: ".$this->newChapterId."}");

        $contentId = Chapter::where('course_id', $this->courseId)->first();
        if (!$contentId) {
            Log::error("No chapter found for courseId: {".$this->courseId."}");
            return;
        }

        $content = Content::where('chapter_id', $contentId->id)->get();
        foreach ($content as $val) {
            Log::info("Copying content: {".$val->content_title."}");

            $data = new Content();
            $data->chapter_id = $this->newChapterId;
            $data->content_title = $val->content_title;
            $data->content_type = $val->content_type;
            $data->content_file = $val->content_file;
            $data->content_link = $val->content_link;
            $data->save();
        }

        Log::info("Job completed successfully for courseId: {".$this->courseId."}");
    }
}
