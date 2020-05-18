<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Message;
use App\SingularItems;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        $text = SingularItems::select('contactpage_text')->first()->contactpage_text;
        return view('contact', ['text' => $text]);
    }

    public function store(ContactRequest $request)
    {
        $request->validated();

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ])->save();

        return redirect('index')->with('success', 'Bedankt voor je bericht, wij zullen er zo snel mogelijk naar kijken!');
    }
}
