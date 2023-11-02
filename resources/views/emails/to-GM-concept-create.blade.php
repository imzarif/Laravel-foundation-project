<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <style>
        td {
            border-bottom: 1px solid #ddd;
            padding: 6px;
        }

        table {
            width: 100%;
            border: 1px solid #ddd;
            font-size: 13px;
            font-family: Arial;



        }

        td:first-child {
            background-color: #f2f6f1;
            width: 20%;
            font-weight: 600;
            color: #000;
        }

        td {
            background-color: #fff;
            font-weight: 400;
            font-family: Arial;
        }
    </style>
</head>

<body style="margin:0px;">
    <p>Dear Concern,</p>
    <p>A concept has been submitted. <a href="{{ route('login') }}">Click here</a> to login</p>
    <p><b>Partner Name:</b> {{ $details['partner_name'] }}</p>
    <p><b>Concept Name:</b> {{ $details['concept_name'] }}</p>
    <p><b>Partner Email:</b> {{ $details['partner_email'] }}</p>
    <p><b>Partner Mobile:</b> {{ $details['partner_phone'] }}</p>
    <div style="text-align: justify;"></div>
    <div style="text-align: justify;">
        <p>
            <span style="font-size: 13px; font-weight: 600; font-family: Arial;">
                Regards,<br> <a href="{{ route('login') }}">IFRS</a>
            </span>
        </p>
    </div>
    <hr style="height: 1px; background-color: #fff;" />
    <div style="font-size: 12px;">
        <p style="font-family: Arial; font-weight: 600; margin-top: -1px;"></p>
    </div>
    </div>
    </div>
</body>

</html>
