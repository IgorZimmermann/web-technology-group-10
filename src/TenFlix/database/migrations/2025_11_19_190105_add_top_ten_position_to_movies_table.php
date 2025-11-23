<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('top_ten_position')->nullable()->after('vote_count');
        });
    }

    
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('top_ten_position');
        });
    }
};
