<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Helper\ApiHelper;

class AnnouncementController extends Controller
{
    public function store(Request $request){
        $announcement = new Announcement();
        $announcement->description = $request->description;
        $announcement->title = $request->title;
        $announcement->save();
        $result = ApiHelper::success('Finance details saved Successfully', $announcement);
        return response()->json($result, 200);
    }

    public function getAllAnnouncements(){
        $announcements = Announcement::all();
        $result = ApiHelper::success('Announcements Loaded Successfully', $announcements);
        return response()->json($result, 200);
    }
}
