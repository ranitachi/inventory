<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
            $insert->email=str_replace('Email : ','',$email);
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
}
