<?php

namespace App\Http\Controllers;

use Mail;
use App\Captain;
use Illuminate\Http\Request;
use App\Exceptions\EmailInUseException;

/**
 * @author Isaac Buitrago
 * Class BusinessEmailController Used to send business emails to TeamLeader Captains
 * @package App\Http\Controllers
 */
class BusinessEmailController extends Controller
{
    public $captain;                                        // Captain to email

    public $TeamLeaderURL = "http://teamleader.test"; // Official TeamLeader URL for email verification


    /**
     * BusinessEmailController constructor.
     * If the email does not exist for a registered captain, return a 404 response
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->captain = Captain::where('email', '=', $request->input('email'))->firstOrFail();
    }

    /**
     * Used to send a verification email to the new Captain
     *
     * @param Request $request
     * @return JSON response for successful request
     */
    public function sendVerificationEmail(Request $request)
    {
        $title = $request->input('title');

        $content = $request->input('content');

        $toEmail = $request->input('email');

        $link = $this->TeamLeaderURL."/confirm";

        // generate a confirmation token for the captain and save it in the database
        $this->captain->confirm_token = bin2hex(openssl_random_pseudo_bytes(16));

        $this->captain->save();

        // save the confirmation token
        $confirmToken = $this->captain->confirmToken;

        // get the member id for the captain and include it in the link
        $memberId = md5($this->captain->id);

        // append the confirmation token and member id to the link and send the verification email

        $link .= "?confirmToken=$confirmToken&memberId=$memberId";

        Mail::send('emails.VerifyEmail', ['title' => $title, 'content'=> $content, 'link'=> $link], function($message) use ($toEmail){

            $message->to($toEmail)->subject("TeamLeader account confirmation");

            $message->from(env('MAIL_USERNAME'));

        });

        return response()->json(['message' => 'Request completed']);

    }

    public function verifyCaptainEmail(Request $request)
    {

    }
}
