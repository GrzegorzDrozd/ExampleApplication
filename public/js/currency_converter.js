$(document).ready(function() {
    $('#currency_converter').on('submit', function(e) {
        e.preventDefault();
        $form = $(this);

        var amount = $("input[name='amount']").val();
        if(amount) {
            $("input[name='amount']").removeClass('error');

            jQuery.getJSON('/currency_converter/convert', {amount:amount}, function (data, textStatus, jqXHR) {
                $("input[name='converted']").val(data.converted);
            }).fail(function () {
                alert("Unable to convert currency. Please try again later.");
            });

        } else {
            $("input[name='amount']").addClass('error');
        }
    });
});
