<?php

use App\Enums\VideoStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();
            $table->foreignId('lecture_id')->constrained()->cascadeOnDelete();
            $table->string('original_file_name');
            $table->string('temp_disk')->default(config('site.disks.videos.temp'));
            $table->string('stream_disk')->default(config('site.disks.videos.stream'));
            $table->string('temp_path')->comment('Temporary file path')->nullable();
            $table->string('stream_name')->comment('Streamable file name')->nullable();
            $table->decimal('processing_percent', 10, 2)->nullable();
            $table->decimal('duration_seconds', 10, 2)->default(0);
            $table->string('mime_type')->nullable();
            $table->datetime('uploaded_at')->nullable();
            $table->datetime('processing_ended_at')->nullable();
            $table->string('status')->default((VideoStatus::PROCESSING)->value);
            $table->text('failure_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
