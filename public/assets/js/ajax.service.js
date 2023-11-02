window.onload = function() {
    var element = document.getElementById('resendOtp');
    if(element){
        element.addEventListener('click', resend_otp);
    }
    $("#otpVerificationForm").submit(function(event) {
        event.preventDefault(); // avoid to execute the actual submit of the form.
        verify_otp();
    });
}
function resend_otp() {
    $("#resendOtp").prop("disabled", true);
    $("#resendOtpContent").hide();
    $(".hide-otp-resend-content").show();
    $.ajax({
                type: "POST",
                dataType: "json",
                url: "/resend-otp",
                data: {
                    email: $("#email").val(),
                    uuid: $("#uuid").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    let { success, no_of_otp_send, messages} = response;
                    if (success) { 
                        $("#otpSendNo").text(no_of_otp_send + '/3');
                        if(no_of_otp_send < 3) {
                            $("#resendOtp").prop( "disabled", false);
                        }
                    } else {
                        $("#resendOtp").prop( "disabled", false);
                    }
                    $("#errorMessage").text(messages);
                },
                error: function (error) {
                   //console.log("error:", error);
                   $("#errorMessage").text('Something is wrong, Please try again.');
                   $("#resendOtp").prop( "disabled", false);
                },
                complete:  function () {
                    $("#resendOtpContent").show();
                    $(".hide-otp-resend-content").hide();
                }
            });
}
function verify_otp() {
    $("#submitOtp").prop("disabled", true);
    $("#submitOtpContent").hide();
    $(".hide-otp-submit-content").show();
    $.ajax({
                type: "POST",
                dataType: "json",
                url: "/verify-otp",
                data: {
                    email: $("#email").val(),
                    otp: $("#otp").val(),
                    uuid: $("#uuid").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) { 
                        window.location.href= "/" + response.user_role_code + "/";
                    } else if(response.error_code === 6005 || response.error_code === 6006) {
                       setTimeout(function () {
                          window.location.href= "/login"
                        }, 3000);
                    }
                    $("#errorMessage").text(response.messages);
                    $("#submitOtp").prop( "disabled", false);
                },
                error: function (error) {
                   //console.log("error:", error);
                   $("#errorMessage").text('Something is wrong, Please try again.');
                   $("#submitOtp").prop( "disabled", false);
                },
                complete:  function () {
                    $("#submitOtpContent").show();
                    $(".hide-otp-submit-content").hide();
                }
            });
        }