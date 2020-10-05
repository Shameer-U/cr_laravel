<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBarcodeToNullableInComplaints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('barcode')->nullable()->change();/*since the column 'barcode' already exists we have to additionally use 'change()' with nullable(), otherwise nullable() is enough*/
            $table->string('status'); // adding new column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('barcode', 300)->change();;
            $table->dropColumn('status');
        });
    }
}
