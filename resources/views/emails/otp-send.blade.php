<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
    <div style="margin:50px auto;width:70%;padding:20px 0">
      <div style="border-bottom:1px solid #eee">
        <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">{{$details['app_name']}}</a>
      </div>
      <p style="font-size:1.1em">Dear Concerned,</p>
      <p>Thank you for logging in to your {{$details['app_name']}} account. Use the following OTP to log in. OTP is valid for 5 minutes</p>
      <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">{{$details['otp']}}</h2>
      <p style="font-size:0.9em;">Regards,<br />{{$details['app_name']}}</p>
      <hr style="border:none;border-top:1px solid #eee" />
      <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
        <p>{{$details['app_name']}}</p>
      </div>
    </div>
  </div>
