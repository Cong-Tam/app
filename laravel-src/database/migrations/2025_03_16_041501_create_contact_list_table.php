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
        Schema::create('contact_list', function (Blueprint $table) {
            $table->foreignId('contact_id')->constrained(table: 'contacts')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('list_id')->constrained(table: 'list_contacts')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_list');
    }
};
