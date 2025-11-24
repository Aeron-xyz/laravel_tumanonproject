<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'sku')) {
            return;
        }

        $this->dropIndexIfExists('products_sku_unique');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->unique()->nullable();
        });
    }

    private function dropIndexIfExists(string $index): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('products', function (Blueprint $table) use ($index) {
                $table->dropUnique($index);
            });

            return;
        }

        $exists = $this->mysqlIndexExists($index);

        if ($exists) {
            DB::statement("ALTER TABLE products DROP INDEX {$index}");
        }
    }

    private function mysqlIndexExists(string $index): bool
    {
        /** @var Collection $indexes */
        $indexes = collect(DB::select('SHOW INDEX FROM products WHERE Key_name = ?', [$index]));

        return $indexes->isNotEmpty();
    }
};

