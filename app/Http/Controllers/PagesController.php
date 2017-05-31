<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
//query builder

use Mail;

use App\Post;

class PagesController extends Controller{
    
    public function index(){
        $posts = Post::orderBy('updated_at','desc')->limit(4)->get();        
        return view('pages.welcome')->withPosts($posts);
    }


    public function about(){
        $first = "Mihály";
        $last = "Szalai";
        $full = $first." ".$last;
        /*
        $data = [];
        $data["email"]="ifjuszalaimihaly@gmail.com"
        $data["full"]=$full;,
        */
        return view('pages.about')->with("fullname",$full);//withFullname($full), conact(full); withData($data);
    }

    public function contact(){
        $email = "ifjuszalaimihaly@gmail.com";
        return view('pages.contact')->withEmail($email);
    }

    public function postcontact(Request $request){
        $this->validate($request, 
            ['email' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10']
            );
        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMassage' => $request->message
            );
        //Mail::queue()
        Mail::send('emails.contact', $data, function($message) use($data){ //nem fér hozáá a requesthez?
            $message->from($data['email']);
            $message->to('ifjuszalaimihaly@gmail.com');
            $message->subject($data['subject']);
        });

        //session

        return redirect()->to('/');
    }




}
