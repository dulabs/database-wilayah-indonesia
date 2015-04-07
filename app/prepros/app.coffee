indonesia = (from, call) ->
    data = {'from': from, 'call': call, 'id': $('#'+from).val()}

    $.ajax
        type: 'POST',
        url: 'ajax.php',
        data: $.param(data),
        success: (data) ->
            $('#'+call).html(data)

    false

$(document).ready ->

