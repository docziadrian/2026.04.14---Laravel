<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feladatok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('cim');
            $table->text('reszletek')->nullable();
            $table->enum('prioritas', ['surgos', 'fontos', 'legyen kesz'])->default('legyen kesz');
            $table->boolean('kesz_van')->default(false);
            $table->date('hatarido')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feladatok');
    }
};
