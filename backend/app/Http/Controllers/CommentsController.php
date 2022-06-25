<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Comments;
use Illuminate\Http\Request;
use DateTime;

class CommentsController extends Controller
{
    public function get(){
    	try
    	{
			$comments = DB::table('comments')
                        ->where("CommentId", null)
                        ->orderBy('id', 'desc')
                        ->get();

            foreach ($comments as $comment) {
                $replies = DB::table('comments')
                        ->where('CommentId', $comment->id)
                        ->orderBy('id', 'desc')
                        ->get();

                $comment->replies = $replies;                                
            }

	        return response()->json(['success' => $comments], 200);  
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function new(Request $request)
    {
        try{
            $this->validate($request, [
            'UserName' => 'required | string',
            'Comment' => 'required | string'
            ]);

            $comment = Comments::create([
                'UserName' => $request->UserName,
                'Comment' => $request->Comment               
            ]);
            

            return response()->json(['success' => $comment], 200);  
            
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reply(Request $request)
    {
        try{
            $this->validate($request, [
            'UserName' => 'required | string',
            'Comment' => 'required | string',
            'CommentId' => 'required | integer'
            ]);

            $reply = Comments::create([
                'UserName' => $request->UserName,
                'Comment' => $request->Comment,
                'CommentId' => $request->CommentId               
            ]);
            

            return response()->json(['success' => $reply], 200);  
            
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}
