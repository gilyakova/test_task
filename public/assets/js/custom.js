$(document).ready(function() {
    if ($('form').find("input[data-datetime=true]").length > 0)
        $('form').find("input[data-datetime=true]").mask("99.99.9999 99:99");

    if ($('.appointments').length > 0) showNewAppointments('active');
});

/**
 * For create/update appointments
 * Get list people by company
 */
function getPeople(obj) {
    if ( ! obj.val()) {
        $('#person_id').html('');
        $('#person_id').attr('disabled', 'disabled');
        return;
    }
    $.ajax({
        type: "GET",
        async: true,
        dataType: "json",
        url: '/get_people/' + obj.val(),
        success: function(answer) {
            if (answer != undefined && answer.result == 'OK') {
                $('#person_id').html('');
                $('#person_id').removeAttr('disabled');
                $('#person_id').append('<option value=""> - </option>');
                $.each(answer.list, function(i, v) {
                    $('#person_id').append('<option value="' + v.id + '">' + v.first_name + ' ' + v.last_name + '</option>');
                });
            } else {
                alert('Server error');
            }
        },
        error: function(answer) { alert('Server error'); }
    });
}

var page = 0;
var status = 'active';

/**
 * Clear list and set params
 */
function showNewAppointments(s) {
    page = 0;
    status = s;
    $('.appointments').html('');
    $('.more').show();
    showAppointments();
}

/**
 * Get list Appointments
 */
function showAppointments() {
    var limit = 10;

    $.ajax({
        type: "GET",
        async: true,
        dataType: "json",
        data: {token: '8542516f8870173d7d1daba1daaaf0a1', status: status, limit: limit, page: page},
        url: '/get_appoinpent_list',
        success: function(answer) {
            if (answer != undefined && answer.result == 'OK') {
                ++page;
                var cnt = 0;
                $.each(answer.list, function(i, v) {
                    ++cnt;
                    $('.appointments').append(makeAppointmentView(v));
                });
                if (cnt < limit) $('.more').hide();
            } else {
                alert('Server error');
            }
        },
        error: function(answer) { alert('Server error'); }
    });
}

/**
 * Appointments detail for list
 */
function makeAppointmentView(item) {
    var str =
      '<div class="row">'
    + '<div class="col-sm-2">'
        + '<b>#</b> ' + item.id
        + '<br><b>Status:</b> <span class="status">' + item.status + '</status>'
    + '</div>'
    + '<div class="col-sm-4">'
        + '<b>Date and time:</b> ' + item.datetime
        + '<br><b>Place:</b> ' + item.place
    + '</div>'
    + '<div class="col-sm-3">'
        + '<b>Company:</b> ' + item.company.name
        + '<br><b>Locality:</b> ' + item.company.locality
    + '</div>'
    + '<div class="col-sm-3">'
        + '<a href="/update/' + item.id + '" class="btn btn-sm btn-primary">Edit</a>'
        + (item.status !== 'confirm' ? '<a href="javascript:void(0);" onclick="appointmentChangeStatus(\'confirm\', $(this), \'' + item.id + '\');" class="btn btn-sm btn-success">Confirm</a>' : '')
        + (item.status !== 'cancel' ? '<a href="javascript:void(0);" onclick="appointmentChangeStatus(\'cancel\', $(this), \'' + item.id + '\');" class="btn btn-sm btn-warning">Cancel</a>' : '')
        + '<a href="javascript:void(0);" onclick="appointmentDel($(this), \'' + item.id + '\');" class="btn btn-sm btn-danger">Delete</a>'
    + '</div>'
    + '</div><hr>';
    return str;
}

/**
 * Set new status
 */
 function appointmentChangeStatus(s, obj, id) {
    $.ajax({
        type: "GET",
        async: true,
        dataType: "json",
        data: {status: s, id: id},
        url: '/set_status',
        success: function(answer) {
            if (answer != undefined && answer.result == 'OK') {
                obj.closest('.row').find('.status').html(s);
                obj.remove();
            } else {
                alert('Server error');
            }
        },
        error: function(answer) { alert('Server error'); }
    });
}

/**
 * Delete record
 */
function appointmentDel(obj, id) {
    if (confirm("Do you want to delet appointment?")) {
        $.ajax({
            type: "GET",
            async: true,
            dataType: "json",
            data: {id: id},
            url: '/delete',
            success: function(answer) {
                if (answer != undefined && answer.result == 'OK') {
                    obj.closest('.row').remove();
                } else {
                    alert('Server error');
                }
            },
            error: function(answer) { alert('Server error'); }
        });
    }
}