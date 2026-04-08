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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable();
            }
            if (!Schema::hasColumn('products', 'kondisi')) {
                $table->string('kondisi')->default('Baru');
            }
            if (!Schema::hasColumn('products', 'stok')) {
                $table->integer('stok')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'brand')) {
                $table->dropColumn('brand');
            }
            if (Schema::hasColumn('products', 'kondisi')) {
                $table->dropColumn('kondisi');
            }
            if (Schema::hasColumn('products', 'stok')) {
                $table->dropColumn('stok');
            }
        });
    }
};
