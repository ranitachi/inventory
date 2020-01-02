<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product_Masuk;
use App\Product_Keluar;
use App\Product;
class ApiController extends Controller
{
    public function getuserbyname(Request $request)
    {
        $name=$request->nama;
        $user=User::where('name','like',"%$name%")->first();
        if($user)
        {
            $data['nama']=$user->name;
            $data['telepon']=$user->telepon;
            $status=200;
        }
        else
        {
            $data['nama']=$name;
            $data['telepon']='';
            $status=404;
        }
        return response()->json([
                'status'=>$status, 
                'data'=>$data
            ]); 
    }

    public function store_user(Request $request)
    {
        $nama=$request->nama;
        $email=$request->email;
        $telepon=$request->telepon;

        $cek=User::where('email',$email)->first();
        if(!$cek)
        {
            $insert=new User;
            $insert->name=$nama;
            $insert->email=strtolower(str_replace('Email : ','',$email));
            $insert->telepon=str_replace('No.HP : ','',$telepon);
            $insert->role='staff';
            $insert->password=bcrypt($telepon);
            $insert->save();

            return response()->json([
                'status'=>200,
                'data' => array('message'=>'Data Anda Berhasil Di Simpan')
            ]);
        }

        return response()->json([
                'status'=>404,
                'data' => array('message'=>'Terjadi Kesalahan')
            ]);
    }
    
    public function store_product_in(Request $request)
    {
        $nama=$request->nama;
        $product_number = $request->product_number;
        $product_name = $request->product_name;
        $vendor = $request->vendor;
        $deskripsi = $request->deskripsi;
        $order_ref = $request->order_ref;
        $jumlah = (int)$request->jumlah;

        $cek=User::where('name',$nama)->first();
        if($cek)
        {
            $cekproduct=Product::where('product_number',$product_number)->first();
            // return $cekproduct;
            if($cekproduct)
            {
                $cekproduct->qty=$cekproduct->qty+$jumlah;
                $cekproduct->save();

                $product_id=$cekproduct->id;
            }
            else
            {
                $prd=new Product;
                $prd->category_id=0;      
                $prd->nama=$product_name;      
                $prd->product_number=$product_number;      
                $prd->vendor=$vendor;      
                $prd->qty=$jumlah;      
                $prd->save();      
                
                $product_id=$prd->id;
            }

            $insert=new Product_Masuk;
            $insert->product_id=$product_id;
            $insert->supplier_id=0;
            $insert->qty=$jumlah;
            $insert->tanggal=date('Y-m-d');
            $insert->deskripsi=$deskripsi;
            $insert->order_ref=$order_ref;
            $insert->received_by=$nama;
            $insert->save();


            return response()->json([
                'status'=>200,
                'data' => array('message'=>'Data Anda Berhasil Di Simpan')
            ]);
        }
        else
        {
            return response()->json([
                'status'=>405,
                'data' => array('message'=>'Akun Anda Belum Terdaftar, Silahkan Daftar Terlebih Dahulu dengan ketik ')
            ]);
        }
    }
    public function store_product_out(Request $request)
    {
        $nama=$request->nama;
        $product_number = $request->product_number;
        $product_name = $request->product_name;
        $vendor = $request->vendor;
        $deskripsi = $request->deskripsi;
        $order_ref = $request->order_ref;
        $jumlah = (int)$request->jumlah;

        $cek=User::where('name',$nama)->first();
        if($cek)
        {
            $cekproduct=Product::where('product_number',$product_number)->first();
            // return $cekproduct;
            if($cekproduct)
            {
                $cekproduct->qty=$cekproduct->qty-$jumlah;
                $cekproduct->save();
                $product_id=$cekproduct->id;

                $insert=new Product_Keluar;
                $insert->product_id=$product_id;
                $insert->customer_id=0;
                $insert->qty=$jumlah;
                $insert->tanggal=date('Y-m-d');
                $insert->deskripsi=$deskripsi;
                $insert->order_ref=$order_ref;
                $insert->received_by=$nama;
                $insert->save();


                return response()->json([
                    'status'=>200,
                    'data' => array('message'=>'Data Anda Berhasil Di Simpan')
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>403,
                    'data' => array('message'=>'Data Anda Input Tidak Ditemukan')
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>405,
                'data' => array('message'=>'Akun Anda Belum Terdaftar, Silahkan Daftar Terlebih Dahulu dengan ketik ')
            ]);
        }
    }
}
