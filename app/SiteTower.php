<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteTower extends Model
{
    use SoftDeletes;
    protected $table='site_tower';
    protected $fillable = [
        'site_id',
        'site_name',
        'class_name',
        'wali_name',
        'provinsi_name',
        'kabupaten_name',
        'kecamatan_name',
        'kelurahan_name',
        'alamat',
        'cluster_fmc_name',
        'vendor_fmc_name',
        'tower_provider_name',
        'type_tower_name',
        'jenis_tower_name',
        'height_tower_name',
        'status_tower_name',
        'owner_tower_name',
        'biaya_sewa_tower',
        'dimensi_lahan',
        'lahan_status_name',
        'harga_sewa_lahan',
        'land_lord',
        'imb_status_name',
        'no_imb_tower',
        'doc_imb',
        'no_sertifikat_lahan',
        'no_kontrak',
        'awal_periode_kontrak',
        'akhir_periode_kontrak',
        'retribusi_skrd',
        'doc',
        'tgl_berlaku_imb_tower',
        'tgl_akhir_imb_tower',
        'status_perpanjangan_sewa_lahan',
        'asset_description',
        'po_sewa_tower_tahun_pertama',
        'po_recuring_tower',
        'po_fmc',
        'type_fmc_name',
        'typemainfmc_name',
        'doc_baps',
        'beban_tower',
        'updated_by',
        'updated_date',
        'updated_datetime',
        'akses_jalan_ke_site',
        'scd_fmc_name',
        'scd_fmc_cluster',
        'area_name',
        'regional_name',
        'departement_name',
        'technical_area_name'
    ];

    public $hidden = ['created_at','updated_at','deleted_at'];
}
