<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div class="invite-block" style="background: #FFF;text-align: center;width: 500px;  border: 1px solid rgba(0,0,0,0.2);margin: 20px auto;">
			<div class="img-right" style="padding: 30px 35px 20px 35px;">
				<h2 style="text-transform: uppercase;font-size: 18px;font-weight:700;margin-top:20px;color:#F07431;">Verify Your Email Address</h2>
				<p>
					Thanks for creating an account with us.	Please follow the link below to verify your email address.
				</p>				
				<a href="{{ URL::to('register/verify/' . $confirmation_code) }}" class="btn-pink" style="background-color: #F07431;color: #FFF;border: none;border-radius: 3px;display: block;width: 400px;text-decoration:none;font-size: 18px;padding: 15px 20px;margin-right: 10px;">Verify My Mail</a>
				<p>If above link doesn't work then click here:<br>
				<a>{{ URL::to('register/verify/' . $confirmation_code) }}</a><p>
			</div>
		</div>
	</body>
</html>