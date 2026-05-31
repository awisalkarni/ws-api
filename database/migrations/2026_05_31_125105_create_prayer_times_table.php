<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('imsak');
            $table->time('subuh');
            $table->time('syuruk');
            $table->time('zohor');
            $table->time('asar');
            $table->time('maghrib');
            $table->time('isyak');
            $table->time('dhuha');
            $table->timestamps();

            $table->unique(['zone_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_times');
    }
};
