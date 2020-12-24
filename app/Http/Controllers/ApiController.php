<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\Product;
use App\SiteTower;
use App\Product_Masuk;
use App\Product_Keluar;
use Illuminate\Http\Request;

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
        $vendor = $request->vendor;
        $deskripsi = $request->deskripsi;
        $order_ref = $request->order_ref;
        $sn = $request->sn;
        $jumlah = (int)$request->jumlah;
      
        $cek=User::where('name',$nama)->first();
        if($cek)
        {
            $cekproduct=Product::where('product_number','like',$product_number)->orWhere('serial_number','like',$sn)->first();
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
                $prd->nama=$deskripsi;      
                $prd->product_number=$product_number;      
                $prd->vendor=$vendor;      
                $prd->qty=$jumlah;      
                $prd->serial_number=$sn;      
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
            $insert->serial_number=$sn;
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
        $jumlah = (int)$request->jumlah;

        $cek=User::where('name',$nama)->first();
        if($cek)
        {
            $cekproduct=Product::where('product_number','like',$product_number)->orWhere('serial_number','like',$product_number)->first();
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
                $insert->deskripsi=$cekproduct->nama;
                $insert->order_ref='-';
                $insert->received_by=$nama;
                $insert->serial_number=$cekproduct->serial_number;
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
    
    public function store_tower(Request $request)
    {
        
        // $rawData = file_get_contents($request->all());
        $postedJson = $request->all();
        return $postedJson;
        // return count($postedJson['data']);
        // return $postedJson['data'][0]['site_id'];
        try{
            // return $pos
            // DB::beginTransaction();
            $status = 1;
            $data = [];
            if(count($postedJson['data']) != 0)
            {
                foreach($postedJson['data'] as $index =>$value)
                {
                    $val = json_decode(json_encode($value), true);
                    $site_id = $value['site_id'];
                    $cek=SiteTower::where('site_id',$site_id)->first();
                    if(!$cek)
                    {
                        $simpan = SiteTower::create($val);    
                    }
                    else
                    {
                        $status = 0;
                        $data[] = $val;
                    }
                }
                // DB::commit();
    
                if($status = 0)
                {
                    return response()->json([
                        'status'=>400,
                        'message' => array('message'=>'Data Telah Tersimpan Dalam Database Sebelumnya'),
                        'data' => $data
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>200,
                        'message' => array('message'=>'Data Telah Tersimpan Dalam Database')
                    ]);
                }
            }
        }catch(Exception $ex)
                {
                    // DB::rollback();
                    return response()->json([
                        'status'=>400,
                        'message' => array('message'=>'Data Tidak Tersimpan Dalam Database')
                    ]);
                }
        
    }
}
