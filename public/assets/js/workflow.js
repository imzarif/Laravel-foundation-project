//Details is hidden as per instructions of Emdad bhai due to client management issues
function subTable(params) {
    if (!params) {
        return "No details available";
    }
   

    var tbody = `<table class='table table-bordred table-striped'>
      `;
    for (var i = 0; i < params.length; i++) {
        tbody += ` 
        <tr>
        <td scope='col'> ${params[i].tas_title}</th>
        <td scope='col'> ${params[i].usr_name}</th>
        <td scope='col'> ${params[i].del_task_due_date}</th>
        </tr>`;
    }
    tbody += `
    </table>`;
    return tbody;
}

function prepareTables(params) {
    var tbody = `<p></p>
    <table class='table table-bordred table-striped mb-3'>
      <thead>
        <tr>
          <th scope='col'>App Number</th>
          <th scope='col'>Process Name</th>
          <th scope='col'>Current Status</th>
          <th scope='col'>Created By</th>
          <th colspan="3" scope='col'>
            <table class='table table-striped'>
            <tr>
                <td scope='col'>Task</th>
                <td scope='col'>Assigned To</th>
                <td scope='col'>Assigned At</th>
            </tr>
            </table>  
          </th>
        </tr>
      </thead>`;
    if (!params.length) {
        return "No Data Available. Please Check Your Network ! ";
    }
    for (var i = 0; i < params.length; i++) {
        tbody += `<tr>
            <td>${params[i].app_number}</td>
            <td>${params[i].pro_name}</td>
            <td>${params[i].app_status}</td>
            <td>${params[i].app_init_usr_username}</td>
            <td>${subTable(params[i].current_task)}</td>

          <tr/>`;
    }
    tbody += `
      </tbody>
    </table>`;
    return tbody;
}


// function prepareTables(params) {
//     var tbody = `<table class='table table-striped'>
//       <thead>
//         <tr>
//           <th scope='col'>App Number</th>
//           <th scope='col'>Process Name</th>
//           <th scope='col'>Current Status</th>
//           <th scope='col'>App Initiate User</th>
//         </tr>
//       </thead>`;
//     if (!params.length) {
//         return "No Data Available";
//     }
//     for (var i = 0; i < params.length; i++) {
//         tbody += `<tr>
//             <td>${params[i].app_number}</td>
//             <td>${params[i].pro_name}</td>
//             <td>${params[i].app_status}</td>
//             <td>${params[i].app_init_usr_username}</td>
//           <tr/>`;
//     }
//     tbody += `
//       </tbody>
//     </table>`;
//     return tbody;
// }
function workflowHisotry(wfAll) {
    showLoading();
    let postParam = new Array();
    wfAll.forEach((element) => {
        //console.log(element.app_uid);
        postParam.push(element.app_uid);
        //console.log(postParam);
    });
    setTimeout(() => {
        window.axios
            .post(appURL + "/api/workflow/post-getcasedata", postParam)
            .then((response) => {
                if(response.status == 200) {
                document.getElementById("workflow_live_history").innerHTML =
                    prepareTables(response.data);
                    hideLoading();
                }else{
                    alert("Something went wrong. Please Check your network")
                }
            });
    }, 2000);
}



  
  
var postData = {
    usr_uid: "",
    tas_uid: "",
    pro_uid: "",
};
var appURL = document.getElementById("APP_URL").value;

function getWorkflowUserUID(userName) {
    //console.log(userName);
    return new Promise((resolve) => {
        setTimeout(() => {
            //console.log("1");
            window.axios
                .get(
                    appURL + "/api/workflow/get-user?userName=".concat(userName)
                )
                .then((response) => {
                    //console.log(response.data);
                    resolve(response.data);
                    //console.log(response.status);
                    //console.log(response.statusText);
                    //console.log(response.headers);
                    //console.log(response.config);
                });
        }, 2000);
    });
}

async function getAssignmentList(userName) {
    showLoading();
    let fetchUsrUID = await getWorkflowUserUID(userName);
    postData.usr_uid = fetchUsrUID;
    setTimeout(() => {
        window.axios
            .get(
                appURL +
                    "/api/workflow/get-assignment?usr_uid=".concat(fetchUsrUID)
            )
            .then((response) => {
               let data = $.map(response.data, function (obj) {
                    obj.id = obj.pro_uid + "," + obj.tas_uid;
                    obj.text = obj.pro_title;
                    return obj;
                });
                $("#selectInput").select2({
                    minimumInputLength: 1,
                    dropdownAutoWidth: true,
                    data: data,
                });
                hideLoading();
                $("#workflowModal").show();
                return data;
            });
    }, 2000);
}

jQuery(document).ready(function () {
    var modal = document.getElementById("workflowModal");

    var btn = document.getElementById("workflowCaseBtn");

    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function () {
        // modal.style.display = "block";
        getAssignmentList(
            document.getElementById("user-email").value.split("@")[0]
        );
    };

    span.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});

var pro_uid_tas_uid;
$("#selectInput").on("change", function () {
    pro_uid_tas_uid = $(this).select2().val().split(",");
    postData.pro_uid = pro_uid_tas_uid[0];
    postData.tas_uid = pro_uid_tas_uid[1];
    //console.log("Final Post Data");
    //console.log(postData);
});

var btnConfirmCaseCreate = document.getElementById("confirmCaseCreate");
btnConfirmCaseCreate.onclick = function () {
    if (confirm("Confirm Create Case")) {
        showLoading();
        setTimeout(() => {
            window.axios
                .get(
                    appURL +
                        "/api/workflow/create-case?pro_uid=" +
                        postData.pro_uid +
                        "&usr_uid=" +
                        postData.usr_uid +
                        "&tas_uid=" +
                        postData.tas_uid
                )
                .then((response) => {
                    //console.log(response.data.app_number);
                    //console.log(response.data.app_uid);
                    //console.log(response.status);
                    //console.log(response.statusText);
                    //console.log(response.headers);
                    //console.log(response.config);
                    $('input[name="app_number"]').val(response.data.app_number);
                    $('input[name="app_uid"]').val(response.data.app_uid);
                    hideLoading();
                    document.getElementById("workflow-case-create").submit();
                });
        }, 2000);
    }
};
