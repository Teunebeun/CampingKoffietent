<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use routes;
use App\ActivityPlanned;
use App\Sponsor;
use App\SingularItems;

class HomePageController extends Controller
{
    public function show()
    {
        $info = SingularItems::first();
        $upcomingActivities = ActivityPlanned::whereDate('start_datetime', '>=', Carbon::now())->orWhere('id', '=', 1)
            ->orderBy('start_datetime')
            ->paginate(2, ['*'], 'upcomingPagination');
        $sponsors = Sponsor::get();
        $instagramPost = $this->instagramAPI();

        $upcomingActivities = $this->checkIfActivityHasOpenVacancy($upcomingActivities);

        return view('index', [
            'info' => $info,
            'upcomingActivities' => $upcomingActivities,
            'sponsors' => $sponsors,
            'instagramPost' => $instagramPost
        ]);
    }

    private function instagramAPI(){
        $key = SingularItems::first()->instagram_api_key;
        $url = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,timestamp,username&access_token=" . $key;
        $cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,timestamp,username&access_token=" . $key);
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($cSession);
        curl_close($cSession);
        $json = json_decode($result, true);
        if(empty($json['data'])){ return;}
        $post = $json['data'][0];
        $americanDate = strtotime(str_replace("/", "-", substr($post['timestamp'], 0, 10)));
        $post['timestamp'] = Date('d-m-Y', $americanDate);
        return $post;
    }

    private function checkIfActivityHasOpenVacancy($upcomingActivities)
    {
        foreach ($upcomingActivities as $activity) {
            $full = true;

            if ($activity->vacancies) {
                foreach ($activity->vacancies as $vacancy) {
                    if (!$vacancy->vacancy_filled && $vacancy->is_open) {
                        $full = false;
                    }
                }
            }
            $activity->filled = $full;
        }
        return $upcomingActivities;
    }
}
