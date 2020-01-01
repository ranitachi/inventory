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
}
