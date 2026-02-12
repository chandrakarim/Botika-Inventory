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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->string('inventory_code')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('serial_number')->nullable();
            $table->text('specification')->nullable();

            $table->enum('status', [
                'baik',
                'rusak',
                'tidak_dipakai',
                'dilelang'
            ])->default('baik');

            $table->foreignId('member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
