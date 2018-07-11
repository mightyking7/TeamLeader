<?php

namespace App\Http\Controllers;

use App\Captain;
use Illuminate\Http\Request;
use App\Exceptions\EmailInUseException;

/**
 * @author Isaac Buitrago
 * Class BusinessEmailController Used to send business emails not related to user authentication
 * @package App\Http\Controllers
 */
class BusinessEmailController extends Controller
{

    /**
     * Used to send an email to the new Captain to validate
     * their provided email.
     *
     * @param Request $request
     * @return JSON response for successful request
     * @throws EmailInUseException if the email exists in the database
     */
    public function validateCaptainEmail(Request $request)
    {
        $title = $request->input('title');

        $content = $request->input('content');

        $toEmail = $request->input('email');

        // if the email already exists in the database, refuse the request
        if(!Captain::where('email', '=', $toEmail)->get()->isEmpty())
        {

            throw new EmailInUseException("Email: $toEmail is already in use. Please log in");
        }

        else
        {
            Mail::send('emails.VerifyEmail', ['title' => $title, 'content'=> $content], function($message) use ($toEmail){


                $message->to($toEmail)->subject("Please verify your TeamLeader account");

                $message->from(env('MAIL_USERNAME'));


            });

            return response()->json(['message' => 'Request completed']);
        }

    }
}
