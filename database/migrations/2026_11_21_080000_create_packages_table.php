<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rental packages from the catalogue: Arabian tents (20' x 20'),
     * Marquee block tents (20' x 40') and LED / sound / lighting sets.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category', 20)->index();       // arabian | block | av
            $table->string('finish', 20)->nullable();      // white | clear (tents only)
            $table->string('tier', 20);                    // basic | deco | premium
            $table->string('code', 4)->nullable();         // catalogue letter: A, B, C ...
            $table->json('name');                          // {"en": "...", "ms": "..."}
            $table->string('size', 20)->nullable();        // 20' × 20'
            $table->json('features');                      // one item per line, per locale
            $table->unsignedInteger('price')->nullable();  // whole ringgit; null = quote on request
            $table->json('note')->nullable();              // e.g. "Free 1 buffet table"
            $table->string('image')->nullable();           // path under public/
            $table->json('gallery')->nullable();           // extra image paths
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('add_ons', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            // Prices in sen (RM2.50 = 250). Block tents sometimes cost more.
            $table->unsignedInteger('price_arabian');
            $table->unsignedInteger('price_block')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('kind', 20)->index();           // event | extra
            $table->string('icon');                        // lucide icon key, see SiteIcon.vue
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('title');
            $table->json('summary');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('add_ons');
        Schema::dropIfExists('packages');
    }
};
