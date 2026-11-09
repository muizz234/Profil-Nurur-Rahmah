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
        Schema::table('berita', function (Blueprint $table) {
            if (! Schema::hasIndex('berita', 'berita_is_published_published_at_index')) {
                $table->index(['is_published', 'published_at'], 'berita_is_published_published_at_index');
            }
        });

        Schema::table('kegiatan', function (Blueprint $table) {
            if (! Schema::hasIndex('kegiatan', 'kegiatan_is_active_index')) {
                $table->index(['is_active'], 'kegiatan_is_active_index');
            }
        });

        Schema::table('galeri', function (Blueprint $table) {
            if (! Schema::hasIndex('galeri', 'galeri_created_at_index')) {
                $table->index(['created_at'], 'galeri_created_at_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            if (Schema::hasIndex('berita', 'berita_is_published_published_at_index')) {
                $table->dropIndex('berita_is_published_published_at_index');
            }
        });

        Schema::table('kegiatan', function (Blueprint $table) {
            if (Schema::hasIndex('kegiatan', 'kegiatan_is_active_index')) {
                $table->dropIndex('kegiatan_is_active_index');
            }
        });

        Schema::table('galeri', function (Blueprint $table) {
            if (Schema::hasIndex('galeri', 'galeri_created_at_index')) {
                $table->dropIndex('galeri_created_at_index');
            }
        });
    }
};
