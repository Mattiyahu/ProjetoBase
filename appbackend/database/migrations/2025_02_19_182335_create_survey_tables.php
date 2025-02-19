<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Sections table
        Schema::create('survey_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('order');
            $table->timestamps();
        });

        // Questions table
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('survey_sections')->onDelete('cascade');
            $table->string('text');
            $table->string('type'); // number, radio, date, select, textarea
            $table->integer('order');
            $table->boolean('required')->default(true);
            $table->timestamps();
        });

        // Options table for radio and select questions
        Schema::create('survey_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('survey_questions')->onDelete('cascade');
            $table->string('value');
            $table->integer('order');
            $table->timestamps();
        });

        // User responses table
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('survey_questions')->onDelete('cascade');
            $table->text('answer');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('survey_responses');
        Schema::dropIfExists('survey_question_options');
        Schema::dropIfExists('survey_questions');
        Schema::dropIfExists('survey_sections');
    }
};
