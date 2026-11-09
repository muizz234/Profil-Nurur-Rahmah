<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            if (! Schema::hasColumn('galeri', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('caption')
                    ->constrained('categories')->nullOnDelete();
            }
        });

        if (Schema::hasColumn('galeri', 'category')) {
            $names = DB::table('galeri')
                ->whereNotNull('category')
                ->where('category', '<>', '')
                ->distinct()
                ->pluck('category');

            foreach ($names as $name) {
                $name = trim((string) $name);
                $slug = Str::slug($name);

                if ($name === '' || $slug === '') {
                    continue;
                }

                $category = DB::table('categories')->where('slug', $slug)->first()
                    ?? DB::table('categories')->whereRaw('LOWER(name) = ?', [Str::lower($name)])->first();

                $categoryId = $category?->id;

                if (! $categoryId) {
                    $categoryId = DB::table('categories')->insertGetId([
                        'name' => $name,
                        'slug' => $slug,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('galeri')->where('category', $name)->update(['category_id' => $categoryId]);
            }

            Schema::table('galeri', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            if (! Schema::hasColumn('galeri', 'category')) {
                $table->string('category')->nullable()->after('caption');
            }
        });

        if (Schema::hasColumn('galeri', 'category_id')) {
            DB::table('galeri')
                ->join('categories', 'categories.id', '=', 'galeri.category_id')
                ->whereNull('galeri.category')
                ->update(['galeri.category' => DB::raw('categories.name')]);

            Schema::table('galeri', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
    }
};
