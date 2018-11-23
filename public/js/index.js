
$(document).ready(function(){
    $('.form-data').submit(function(){

        var $inputs = $('.form-data :input');

        var values = {};

        $inputs.each(function() {
            values[this.name] = $(this).val();
        });

        // var data = new FormData();
        // data.append('latitude',values.tripInitLatitude);
        // data.append('longitude',values.tripInitLongitude);
        var data = {
            "latitude":values.tripInitLatitude,
            "longitude":values.tripInitLongitude
        }

        console.log(data);
        $.ajax({
            url: "http://52.15.208.224:5555/viaje",
            type: "POST",
            crossDomain: true,
            data: JSON.stringify(data),
            dataType: "jsonp",
            error: function(xhr, ajaxOptions, thrownError) {
                // alert("error");
                // alert(xhr.responseText);
                console.log(xhr.status);
            },
            success: function(data) {
                alert("data");
            }
            
        });
        return false;
    });
});
