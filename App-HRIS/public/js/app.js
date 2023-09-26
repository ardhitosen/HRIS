$(document).ready(function () {
    $('#employeeTable').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: 9
        }]
    });
});

$(document).ready(function () {
    $('#payrollTable').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: 9
        }]
    });
});

$(document).ready(function () {
    $('#attendanceTable').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: 9
        }]
    });
});

$(document).ready(function () {
    $('#schedulerTable').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: 8
        }]
    });
});

$(document).ready(function () {
    $('#overtimeTable').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: 7
        }]
    });
});

$(document).ready(function () {
    $('#timoffTable').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: 6
        }]
    });
});

$(document).ready(function () {
    $('#reimbursementTable').DataTable({
        "columnDefs": [{
            orderable: false,
            targets: 6
        }]
    });
});

new DataTable('#timeoff_frontend');
new DataTable('#overtimeTable_frontend');
new DataTable('#reimbursementTableFrontend');


function showTime() {
    var date = new Date();

    document.getElementById('time').innerHTML = date.toLocaleTimeString();
}

setInterval(showTime, 1000);