<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\MessageResource;

class MessagesController extends Controller
{
    /**
     * Register Auth middleware for this controller
     */
    // public function __contruct() {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Message::whereNull('parent_id')->with('user')->with('categories')->orderBy('created_at', 'desc');
        
        if($request->has('categories')) {
            $category_ids = explode(",", $request->get('categories'));
            
            $messages->whereHas('categories', function($query) use ($category_ids) {
                $query->whereIn('categories.id', $category_ids);
            });
        }

<<<<<<< HEAD
        return response()->json($messages->paginate(10));
=======
        return MessageResource::collection($messages->paginate(10));
>>>>>>> 66253cbcfc1c83845c37d83445d3100285946d0c
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request, Message $message)
    {
        $user = Auth::user();

        $comment = new Message();
        $comment->title = "";
        $comment->content = $request->get('comment');
        $comment->user()->associate($user);
        $comment->message()->associate($message);
        $comment->save();

        return view('messages.show', ['message' => $message]);       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Message $message)
    {       
        return view('messages.show', ['message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
