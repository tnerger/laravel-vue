<?php

use App\Models\ListingImage;
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
        Schema::table('listing_images', function (Blueprint $table) {
            $table->dropColumn('filename');
        });

        Schema::create('listing_image_sizes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('filename');
            $table->string('size');
            $table->foreignIdFor(ListingImage::class)->constant('listings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_image_sizes');
        Schema::table('listing_images', function (Blueprint $table) {
            $table->string('filename');
        });
    }
};
