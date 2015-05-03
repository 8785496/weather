$(document).ready(function () {
    $('#getweather').click(function () {
        $.ajax({
            method: "GET",
            url: "/index.php",
            contentType: "application/json",
            data: {weather: "nsk"}
        }).done(function (response) {
            console.log(response);
            var result = 'Температура: ' +  response.result.temp_current_c + ' °C<br>';
            result += response.result.cloud_title + ', ' + response.result.precip_title + '<br>';
            result += 'Ветер: ' + response.result.wind_avg + ' м/с, ' + response.result.wind_ru_full + '<br>';
            result += 'Атм. давление: ' + response.result.pressure_avg + ' мм рт. ст.<br>';
            result += 'Влажность: ' + response.result.humidity_avg + ' %';
            $('#weather').html(result);
        });
    });
});
