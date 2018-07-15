<?php

namespace App\Http\Controllers\AccountManager;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    private $successMessage; // default success message to send in response

    private $status;         // request status, defaulted to bad request

    private $TeamLeaderURL;  // Official TeamLeader URL for email verification

    /**
     * BusinessEmailController constructor.
     */
    public function __construct(Request $request)
    {
        $this->successMessage = "Request complete";

        $this->status = 400;

        $this->TeamLeaderURL = "http://teamleader.test";
    }

    /**
     * Used to send a verification email to the new Captain
     * The Captain must have already successfully created an account
     * in order to receive this verification email.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse response for successful request
     * @throws ModelNotFoundException if the email is not in the database
     */
    public function sendVerificationEmail(Request $request)
    {
        $title = $request->input('title');     // title of email

        $content = $request->input('content'); // content of email

        $toEmail = $request->input('email');   // email to verify

        $link = $this->TeamLeaderURL . "/confirm";  // link to verification page

        $confirmToken = null;                       // email confirmation token

        $this->errorMessage = "One or more pieces of Captain information is not valid";

        // validate input and send the email only if the Captain has a registered account with TeamLeader
        if (!empty($title) && !empty($content) && !empty($toEmail))
        {

            // generate a confirmation token and save it in the database
            $confirmToken = bin2hex(random_bytes(16));

            // retrieve the Captain instance
            $this->captain = Captain::where('email', '=', $toEmail)->firstOrFail();

            $this->captain->confirm_token = $confirmToken;

            $this->captain->save();

            // append the confirmation token to the link
            $link .= "?confirmToken=$confirmToken";

//            Mail::send('emails.VerifyEmail', ['title' => $title, 'content' => $content, 'link' => $link], function ($message) use ($toEmail) {
//
//                $message->to($toEmail)->subject("TeamLeader account confirmation");
//
//                $message->from(env('MAIL_USERNAME'));
//
//            });

            return($this->sendSuccessMessage());
        }
        else {

            return($this->sendErrorMessage($this->errorMessage));
        }

    }

    /**
     * Used to verify the Captains email after they have accessed the link sent to them
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse error if invalid request is received, success other wise
     * @throws ModelNotFoundException if the confirmToken is not in the database
     */
    public function verifyCaptainEmail(Request $request)
    {
        $confirmToken = $request->input('confirmToken');

        $this->errorMessage = "Confirmation token is not valid";

        // The confirmation token must be valid and stored in the database to process the request

        if (empty($confirmToken))
        {
            return($this->sendErrorMessage($this->errorMessage));
        }
        else {

            // mark the email as verified in the database
            $this->captain = Captain::where('confirm_token', '=', $confirmToken)->firstOrFail();

            $this->captain->email_verified = 1;

            $this->captain->save();

            return($this->sendSuccessMessage("The email has been verified"));
        }

    }

    /**
     * Used to tailor the success message to send in a response
     * @param null $message Sent in response if not null, else the class default success message is used
     * @return \Illuminate\Http\JsonResponse with message and status
     */
    private function sendSuccessMessage($message=null)
    {
        if(empty($message))
        {
            $statusMessage = $this->successMessage;
        }
        else{
            $statusMessage = $message;
        }

        return response()->json(['message' => $statusMessage]);

    }

    /**
     * Used to tailor the error message to send in a response
     * @param $message to be sent in response
     * @param null $status of the request to send if not null, else class default status code is used
     * @return \Illuminate\Http\JsonResponse with message and status
     */
    private function sendErrorMessage($message , $status=null)
    {
        $statusCode=null;

        if(empty($status))
        {
            $statusCode = $this->status;
        }
        else
        {
            $statusCode = $status;
        }

        return response()->json(["message" => $message], $statusCode);
    }

}
