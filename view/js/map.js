ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
        center: [55.39440246, 86.08778600],
        zoom: 5
    });
    // массив городов
    var cities = [
        {city: 'kemerovo', coord: [55.39440246, 86.08778600]},
        {city: 'nsk', coord: [55.00081759, 82.95627700]},
        {city: 'krsk', coord: [56.02278829, 92.89742450]},
        {city: 'omsk', coord: [55.12276857, 73.37843000]},
        {city: 'tomsk', coord: [56.50682347, 84.97990300]},
        {city: 'barnaul', coord: [53.31831663, 83.68515200]}
    ];
    var placemarks = [];
    cities.forEach(function (item) {
        console.log(item);
        placemarks.push(new ymaps.Placemark(item.coord, {
            hintContent: "Нажмите, чтобы узнать погоду",
            city: item.city
        }, {
            // Запретим замену обычного балуна на балун-панель.
            balloonPanelMaxMapArea: 0,
            preset: 'islands#dotIcon',
            iconColor: '#3b5998',
            // Заставляем балун открываться даже если в нем нет содержимого.
            openEmptyBalloon: true
        }));
    });

    placemarks.forEach(function (placemark) {
        // Обрабатываем событие открытия балуна на геообъекте:
        // начинаем загрузку данных, затем обновляем его содержимое.
        placemark.events.add('balloonopen', function (e) {
            var target = e.get('target');
            var city = target.properties.get('city');
            //console.log(target.properties.get('city'));
            target.properties.set('balloonContent', "Идет загрузка данных...");
            $.ajax({
                method: "GET",
                url: "/index.php",
                contentType: "application/json",
                data: {weather: city}
            }).done(function (response) {
                console.log(response);
                var result = '<div><div class="weather">Температура: <b>' + response.result.temp_current_c + ' °C</b><br>';
                result += response.result.cloud_title + ', ' + response.result.precip_title + '<br>';
                result += 'Ветер: ' + response.result.wind_avg + ' м/с, ' + response.result.wind_ru_full + '<br>';
                result += 'Атм. давление: ' + response.result.pressure_avg + ' мм рт. ст.<br>';
                result += 'Влажность: ' + response.result.humidity_avg + ' %</div>';
                result += '<div class="chart" id="' + city + '"></div></div>';
                target.properties.set('balloonContent', result);
                chart(city);
            });
        });
        myMap.geoObjects.add(placemark);
    });
}
