<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transportation_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['car', 'van', 'bus', 'boat', 'plane']);
            $table->integer('capacity');
            $table->decimal('price_per_trip', 10, 2);
            $table->enum('status', ['active', 'inactive', 'maintenance']);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transportation_vehicles');
    }
};

