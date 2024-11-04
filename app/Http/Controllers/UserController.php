<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailCommunication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use DB;
use App\Notifications\UserCommunicationNotification;



class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function sendEmail(Request $request){
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    DB::beginTransaction();

    try {
        $user = User::findOrFail($validatedData['user_id']);

        EmailCommunication::create([
            'user_id' => $user->id,
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
        ]);

        Notification::route('mail', $user->email)
            ->notify(new UserCommunicationNotification($validatedData['subject'], $validatedData['message']));
        DB::commit();
        return redirect()->route('send.email.index')
            ->with('success', 'Email sent successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to send email. Please try again later.'], 500);
    }
}

    public function getEmailHistory($userId){
        $emails = EmailCommunication::where('user_id', $userId)->get();
        return response()->json($emails);
    }
}
