<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKolomDeskripsiKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_keluar', function (Blueprint $table) {
            $table->text('deskripsi')->nullable();
            $table->string('order_ref')->nullable();
            $table->string('ticket_no')->nullable();
            $table->string('order_request_datetime')->nullable();
            $table->string('delivery_datetime')->nullable();
            $table->string('sn_deliver')->nullable();
            $table->string('site_name')->nullable();
            $table->string('requestor_name')->nullable();
            $table->string('received_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_keluar', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->dropColumn('order_ref');
            $table->dropColumn('ticket_no');
            $table->dropColumn('order_request_datetime');
            $table->dropColumn('delivery_datetime');
            $table->dropColumn('sn_deliver');
            $table->dropColumn('site_name');
            $table->dropColumn('requestor_name');
            $table->dropColumn('received_by');
        });
    }
}
