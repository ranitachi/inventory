<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteTowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_tower', function (Blueprint $table) {
            $table->increments('id');
            $table->string("site_id")->nullable();
            $table->string("site_name")->nullable();
            $table->string("class_name")->nullable();
            $table->string("wali_name")->nullable();
            $table->string("provinsi_name")->nullable();
            $table->string("kabupaten_name")->nullable();
            $table->string("kecamatan_name")->nullable();
            $table->string("kelurahan_name")->nullable();
            $table->string("alamat")->nullable();
            $table->string("cluster_fmc_name")->nullable();
            $table->string("vendor_fmc_name")->nullable();
            $table->string("tower_provider_name")->nullable();
            $table->string("type_tower_name")->nullable();
            $table->string("jenis_tower_name")->nullable();
            $table->string("height_tower_name")->nullable();
            $table->string("status_tower_name")->nullable();
            $table->string("owner_tower_name")->nullable();
            $table->string("biaya_sewa_tower")->nullable();
            $table->string("dimensi_lahan")->nullable();
            $table->string("lahan_status_name")->nullable();
            $table->string("harga_sewa_lahan")->nullable();
            $table->string("land_lord")->nullable();
            $table->string("imb_status_name")->nullable();
            $table->string("no_imb_tower")->nullable();
            $table->string("doc_imb")->nullable();
            $table->string("no_sertifikat_lahan")->nullable();
            $table->string("no_kontrak")->nullable();
            $table->string("awal_periode_kontrak")->nullable();
            $table->string("akhir_periode_kontrak")->nullable();
            $table->string("retribusi_skrd")->nullable();
            $table->string("doc")->nullable();
            $table->string("tgl_berlaku_imb_tower")->nullable();
            $table->string("tgl_akhir_imb_tower")->nullable();
            $table->string("status_perpanjangan_sewa_lahan")->nullable();
            $table->string("asset_description")->nullable();
            $table->string("po_sewa_tower_tahun_pertama")->nullable();
            $table->string("po_recuring_tower")->nullable();
            $table->string("po_fmc")->nullable();
            $table->string("type_fmc_name")->nullable();
            $table->string("typemainfmc_name")->nullable();
            $table->string("doc_baps")->nullable();
            $table->string("beban_tower")->nullable()->default(0);
            $table->string("updated_by")->nullable();
            $table->string("updated_date")->nullable();
            $table->string("updated_datetime")->nullable();
            $table->string("akses_jalan_ke_site")->nullable();
            $table->string("scd_fmc_name")->nullable();
            $table->string("scd_fmc_cluster")->nullable();
            $table->string("area_name")->nullable();
            $table->string("regional_name")->nullable();
            $table->string("departement_name")->nullable();
            $table->string("technical_area_name")->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_tower');
    }
}
