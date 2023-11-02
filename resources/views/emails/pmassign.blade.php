
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<style>
td{
    border-bottom: 1px solid #ddd;
    padding: 6px;
}
table{
width:100%;
border:1px solid #ddd;
font-size:13px;
font-family: Arial;



}
td:first-child{
    background-color:#f2f6f1;
    width:20%;
    font-weight:600;
    color:#000;
}
td{
    background-color:#fff;
    font-weight:400;
    font-family: Arial;
}
</style>
</head>
<body style="margin:0px;">
    <div style="padding: 20px; margin: 20px; font-family: Arial;">
    <div style="border: 1px solid #ddd; width: 80%; padding: 40px; margin: auto;">
    <div style="text-align: justify;">
    <p style="font-family: Arial; font-size: 13px;">Dear <b><b>{{$details['assigned_pm']}}</b><br /></b></p>
    <p><font style="font-size: 13px; font-family: Arial;"><b><b>{{$details['assigned_by']}}</b></b> has assigned the following <span>concept to you</span>.<br /></font></p>
    <p style="font-size: 13px; font-family: Arial;"><a href="{{ route('login') }}">Click here</a> to login</p>
    </div>
    <table>
    <tbody>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Concept ID</td>
        <td style="width: 30%;">{{$details['concept_id']}}</td>
    </tr>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Concept Name</td>
        <td style="width: 30%;">{{$details['concept_name']}}</td>
    </tr>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Concept Summary</td>
        <td style="width: 30%;">{{$details['concept_summary']}}</td>
    </tr>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Project Category</td>
        <td style="width: 30%;">{{$details['project_category']}}</td>
    </tr>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Partner Name</td>
        <td style="width: 30%;">{{$details['partner_name']}}</td>
    </tr>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Partner Email</td>
        <td style="width: 30%;">{{$details['user_email']}}</td>
    </tr>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Partner Mobile</td>
        <td style="width: 30%;">{{$details['company_phone'] ? $details['company_phone'] : '--'}}</td>
    </tr>
    <tr>
        <td style="background-color: #f2f6f1; width: 20%;">Assigned Date</td>
        <td style="width: 30%;">{{$details['assigned_date']}}</td>
    </tr>
    </tbody>
    </table>
    <div style="text-align: justify;"></div>
    <div style="text-align: justify;">
    <p><span style="font-size: 13px; font-weight: 600; font-family: Arial;">Regards,<br> <a href="{{ route('login') }}">IFRS</a></span></p>
    </div>
    <hr style="height: 1px; background-color: #fff;" />
    <div style="font-size: 12px;">
    <p style="font-family: Arial; font-weight: 600; margin-top: -1px;"></p>
    </div>
    </div>
    </div>
</body>
</html>
