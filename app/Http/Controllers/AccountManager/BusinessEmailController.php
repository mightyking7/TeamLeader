<?php

namespace App\Http\Controllers\AccountManager;

use Mail;
use App\Captain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @author Isaac Buitrago
 * Class BusinessEmailController Used to send business emails to TeamLeader Captains
 * @package App\Http\Controllers
 */
class BusinessEmailController extends Controller
{
    private $captain;        // Captain to email

    private $errorMessage;   // custom error message to send in response

    private $successMessage; // success message to send in response

    private $TeamLeaderURL = "http://teamleader.test"; // Official TeamLeader URL for email verification


    /**
     * BusinessEmailController constructor.
     * Create a captain from the given email, if the email does not
     * exists or is null return a 404 response.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        // Email verification request
        if(!empty($request->input('email')))
        {
            $this->captain = Captain::where('email', '=', $request->input('email'))->firstOrFail();
        }

        $this->successMessage = "Request completed";
    }

    /**
     * Used to send a verification email to the new Captain
     *
     * @param Request $request
     * @return JSON response for successful request
     */
    public function sendVerificationEmail(Request $request)
    {
        $title = $request->input('title');     // title of email

        $content = $request->input('content'); // content of email

        $toEmail = $request->input('email');   // email to verify

        $link = $this->TeamLeaderURL."/confirm";    // link to verification page

        // generate a confirmation token for the captain and save it in the database
        $confirmToken = bin2hex(random_bytes(16));

        $this->captain->confirm_token = $confirmToken;

        $this->captain->save();

        // append the confirmation token to the link and send the verification email

        $link .= "?confirmToken=$confirmToken";

        Mail::send('emails.VerifyEmail', ['title' => $title, 'content'=> $content, 'link'=> $link], function($message) use ($toEmail){

            $message->to($toEmail)->subject("TeamLeader account confirmation");

            $message->from(env('MAIL_USERNAME'));

        });

        return response()->json(['message' => $this->successMessage, 'status' => http_response_code()]);

    }

    /**
     * Used to verify the Captains email after they have accessed the link sent to them
     * @param Request $request
     * @return Client error if invalid request is received, success other wise
     */
    public function verifyCaptainEmail(Request $request)
    {
        $confirmToken = $request->input('confirmToken');

        $this->errorMessage = "Confirmation token is not valid";

        $this->successMessage = "The email has been verified";

        // default to bad request
        http_response_code(400);

        // Both the confirmation token and the member id must be valid for the request to process
        if(empty($confirmToken))
        {
            return response()->json(['message' => $this->errorMessage, 'status' => http_response_code()]);
        }

        else {

            if(Captain::where('confirm_token', '=', $confirmToken)->get()->isEmpty())
            {
                return response()->json(["message"=> $this->errorMessage, "status"=> http_response_code()]);
            }

            else
            {
                http_response_code(200);

                return response()->json(['message' => $this->successMessage, "status"=> http_response_code()]);
            }
        }

    }
}
