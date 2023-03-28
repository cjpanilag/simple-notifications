<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('simple_devices', static function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignIdFor(starterKit()->getUserModel())->nullable()->constrained();
            $table->string('device_id')->unique();
            $table->string('unique_id')->unique()->nullable();
            $table->string('brand')->index()->nullable();
            $table->string('type')->index()->nullable();
            $table->string('name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('system_name')->nullable();
            $table->string('system_version')->nullable();
            $table->string('version')->nullable();
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('simple_devices');
    }
};
