<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppealFormRequest;
use App\Sanitizers\PhoneSanitizer;
use Illuminate\Http\Request;
use App\Models\Appeal;
use function view;

class AppealController extends Controller
{
    public function form()
    {
        return view('appeal', ['success' => session('success', false)]);
    }

    public function send(AppealFormRequest $request)
    {
        $data = $request->validated();

        $appeal = new Appeal();
        $appeal->name = $data['name'];
        $appeal->phone = PhoneSanitizer::sanitize($data['phone']);
        $appeal->email = $data['email'];
        $appeal->message = $data['message'];
        $appeal->save();

        return redirect(route('appeal.form'))->with(['success' => true]);
    }
}
