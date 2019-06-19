<?php

namespace App\Http\Controllers;
use Newsletter;

use Illuminate\Http\Request;

class EmailSubscribeController extends Controller
{
    public function subscribe(Request $request)
    {	    

        $request->validate([
            'email' => 'required'
        ]);

    	$check = Newsletter::isSubscribed($request->email);

    	if ($check == 1) {
    		flash('Your email already has been subscribed')->info()->important();
    		return back();

    	} else {

	    	$subscribe_email = Newsletter::subscribe($request->email);

	    	if (isset($subscribe_email)) {
	    		flash('Your email has been subscribe successfully')->success()->important();
		    	return back();
	    	} else {
	    		flash('Please check your email')->info()->important();
		    	return back();
	    	}

    	}

    }
}
