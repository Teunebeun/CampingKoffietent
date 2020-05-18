<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class CMSInboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Sort all messages by placing unread messages on top, then sorting by creation_date (either descending or ascending, depending on the toggle state)
    public function index(Request $request) {
        $sortByRead = ($request->query('sortByRead') === "0") ? false : true;
        $sortByDate = ($request->query('sortByDate') === "0") ? false : true;

        $messages = Message::all()->sort(function($first, $second) use ($sortByDate, $sortByRead) {
            $dateSort = (strtotime($first->created_at) > strtotime($second->created_at)) ? -1: 1;
            $readSort = ($first->unread === $second->unread) ? 0 : (($first->unread > $second->unread) ? -1 : 1);

            return ($sortByRead && $readSort !== 0) ? $readSort : $dateSort * ($sortByDate ? 1 : -1);
        });

        return view('cms.inbox.CMSinbox', [
            'messages' => $messages,
            'sortByDate' => !$sortByDate,
            'sortByRead' => !$sortByRead,
        ]);
    }

    public function update(Message $message) {
        $message->unread = true;
        $message->save();
        return redirect()->route('inbox.index');
    }

    public function show(Message $message) {
        $message->unread = false;
        $message->save();
        return view('cms.inbox.CMSmessage', ['message' => $message]);
    }

    public function destroy(Message $message) {
        try {
            $message->delete();
        } catch(\Exception $exception) {
            error_log($exception);
            dd($exception);
        }

        return redirect()->route('inbox.index')->withInput();
    }
}
