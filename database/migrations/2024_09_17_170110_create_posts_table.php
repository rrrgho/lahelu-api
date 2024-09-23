<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            if(config('database.default') == 'pgsql')
                $table->uuid('id')->primary()->default(DB::raw('gen_uuid()'));
            else if(config('database.default') == 'mysql')
                $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->uuid('user_id');
            $table->string('caption');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('like')->default(0);
            $table->integer('unlike')->default(0);
            $table->boolean('is_sensitive')->default(false);
            $table->boolean('is_onrule')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
