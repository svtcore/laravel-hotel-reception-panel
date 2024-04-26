$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.search-input').on('input', function() {
        var searchTerm = $(this).val();
        var url = $('#search_guest_url').val();
        if (searchTerm.length >= 4) {
            $.ajax({
                url: url,
                method: 'POST',
                data: { guestName: searchTerm },
                success: function(response) {
                    var resultsHtml = '';
                    response.forEach(function(result) {
                        resultsHtml += '<li class="result-item" data-id="' + result.id + '">' + result.first_name + ' ' + result.last_name + ' | ' + result.dob + '</li>';
                    });
                    $('.search-results').html(resultsHtml);
                }
            });
        } else {
            $('.search-results').empty();
        }
    });

    $(document).on('click', '.result-item', function() {
        var selectedValue = $(this).text();
        var selectedId = $(this).attr('data-id');
        $('.search-input').val(selectedValue);
        $('#related_guest_id').val(selectedId);
        $('.search-results').empty();
    });

    $('.add-btn').on('click', function() {
        var selectedValue = $('.search-input').val();
    });
});