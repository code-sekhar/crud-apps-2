<?php

namespace App\Http\Controllers;

use App\Models\school;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(){
        $data = DB::table('schools')
                ->join('users', 'schools.emailId', '=', 'users.email')
                ->select('schools.*', 'users.name','users.email','users.phone')
                ->get();
        return response()->json([
            'message' => 'success',
            'data' => $data,
            'status' => 200,
            'success'=>true
        ]);
    }
    public function blogpost(Request $request){
        try{
            $request->validate([
                'blog_title' => 'required|unique:schools|max:255',
                'blog_description' => 'required|unique:schools',
                'emailId'=>'required',
                'status'=>'required'
            ]);

            $post = school::create([
                'emailId'=>$request->emailId,
                'blog_title'=>$request->blog_title,
                'blog_description'=>$request->blog_description,
                'status'=>$request->status
            ]);
            return response()->json([
                'message' => 'success',
                'data' => $post,
                'status' => 200,
                'success'=>true
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 400,
                'success'=>false,
                'error'=>true,
            ],400);
        }
    }
    //delete api
    public function destroy($id){
        try{
            $post = school::find($id);
            if(!$post){
                return response()->json([
                    'message' => 'Record not found',
                    'status' => 404,
                    'success'=>false,
                ],404);
            }
            $post->delete();
            return response()->json([
                'message' => 'Record deleted',
                'status' => 200,
                'success'=>true,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 400,
                'success'=>false,
                'error'=>true,
            ],400);
        }
    }
    //post update
    public function updatepost(Request $request,$id){
        try{
            $post = school::find($id);
            if(!$post){
                return response()->json([
                    'message' => 'Record not found',
                    'status' => 404,
                    'success'=>false,
                ]);
            }
            $validateData = $request->validate([
                'blog_title' => 'required|unique:schools|max:255',
                'blog_description' => 'required|unique:schools',
                'emailId'=>'required',
                'status'=>'required'
            ]);


            $post->blog_title = $validateData['blog_title'];
            $post->blog_description = $validateData['blog_description'];
            $post->emailId = $validateData['emailId'];
            $post->status = $validateData['status'];
            $post->save();
            return response()->json([
                'message' => 'Record updated',
                'status' => 200,
                'success'=>true,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 400,
                'success'=>false,
                'error'=>true,
            ],400);
        }
    }
    public function singlepost($id){
       try{
           $post = school::find($id);
           if(!$post){
               return response()->json([
                   'message' => 'Record not found',
                   'status' => 404,
                   'success'=>false,
               ],404);
           }
           return response()->json([
               'message' => 'success',
               'data' => $post,
               'status' => 200,
           ],200);
       }catch(\Exception $e){
           return response()->json([
               'message' => $e->getMessage(),
               'status' => 400,
               'success'=>false,
               'error'=>true,
           ],400);
       }
    }
}
