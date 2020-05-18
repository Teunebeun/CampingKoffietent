<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Initiative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CMSSendInitiativeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sortBySeen = ($request->query('sortByRead') === "0") ? false : true;
        $sortByDate = ($request->query('sortByDate') === "0") ? false : true;

        $initiatives = Initiative::all()->sort(function ($first, $second) use ($sortByDate, $sortBySeen) {
            $dateSort = (strtotime($first->datetime) > strtotime($second->datetime)) ? -1 : 1;
            $readSort = ($first->seen === $second->seen) ? 0 : (($first->seen < $second->seen) ? -1 : 1);

            return ($sortBySeen && $readSort !== 0) ? $readSort : $dateSort * ($sortByDate ? 1 : -1);
        });

        return view('cms.send_initiative.index', [
            'initiatives' => $initiatives,
            'sortByDate' => !$sortByDate,
            'sortBySeen' => !$sortBySeen,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $initiative = Initiative::findOrFail($id);
        $initiative->seen = true;
        $initiative->save();

        return view('cms.send_initiative.show', ['initiative' => $initiative]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $initiative = Initiative::findOrFail($id);
        try {
            $initiative->delete();
        } catch (\Exception $exception) {
            error_log($exception);
            dd($exception);
        }

        return redirect()->route('send_initiative.index')->with('success', 'Ingezonden initiatief verwijderd');
    }
}
