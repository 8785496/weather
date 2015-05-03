var myMap;

// Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);

//function init() {
//    // Создание экземпляра карты и его привязка к контейнеру с
//    // заданным id ("map").
//    myMap = new ymaps.Map('map', {
//        // При инициализации карты обязательно нужно указать
//        // её центр и коэффициент масштабирования.
//        center: [55.39440246, 86.08778600], // Новосибирск
//        zoom: 7
//    });
//}

function init () {
    var myMap = new ymaps.Map("map", {
            center: [55.39440246, 86.08778600],
            zoom: 5
        }),
        // массив городов
        cities = [
            {city: 'kemerovo', coord: [55.39440246, 86.08778600]}
        ];
        // Метка, содержимое балуна которой загружается с помощью AJAX.
        placemark = new ymaps.Placemark(
            [55.39440246, 86.08778600], 
            {
                iconContent: "Узнать адрес",
                hintContent: "Перетащите метку и кликните, чтобы узнать адрес",
                city: "kemerovo"
            }, 
            {
                // Запретим замену обычного балуна на балун-панель.
                balloonPanelMaxMapArea: 0,
                //draggable: "true",
                preset: "islands#blueStretchyIcon",
                // Заставляем балун открываться даже если в нем нет содержимого.
                openEmptyBalloon: true
            }
        );

    // Обрабатываем событие открытия балуна на геообъекте:
    // начинаем загрузку данных, затем обновляем его содержимое.
    placemark.events.add('balloonopen', function (e) {
        var target = e.get('target');
        //console.log(target.properties.get('city'));
        target.properties.set('balloonContent', "Идет загрузка данных...");
        $.ajax({
            method: "GET",
            url: "/index.php",
            contentType: "application/json",
            data: {weather: target.properties.get('city')}
        }).done(function (response) {
            console.log(response);
            var result = 'Температура: ' +  response.result.temp_current_c + ' °C<br>';
            result += response.result.cloud_title + ', ' + response.result.precip_title + '<br>';
            result += 'Ветер: ' + response.result.wind_avg + ' м/с, ' + response.result.wind_ru_full + '<br>';
            result += 'Атм. давление: ' + response.result.pressure_avg + ' мм рт. ст.<br>';
            result += 'Влажность: ' + response.result.humidity_avg + ' %';
            //$('#weather').html(result);
            target.properties.set('balloonContent', result);
        });
    });

    myMap.geoObjects.add(placemark);
}
