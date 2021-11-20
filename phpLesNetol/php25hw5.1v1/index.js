var myMap,
    latitude,
    longitude,
    coordsIndex = window.location.href.search('result='),
    resultsQuantity = $('.result').length;

function init() {
    myMap = new ymaps.Map("map", {
        center: [latitude, longitude],
        zoom: 9
    });

    if (resultsQuantity !== 0) {
        myPlacemark = new ymaps.Placemark(
            [latitude, longitude]
        );

        myMap.geoObjects.add(myPlacemark);
    }
}

if (resultsQuantity > 0 && coordsIndex === -1) {
    var coords = $('a:eq(0)').find('h4').html();
    latitude = coords.substr(0, coords.indexOf(' '));
    longitude = coords.substr(coords.indexOf(' ') + 1);

    ymaps.ready(init);
}

if (resultsQuantity > 0 && coordsIndex > 0) {
    coords = window.location.href.substr(coordsIndex + 7);
    latitude = coords.substr(0, coords.indexOf('+'));
    longitude = coords.substr(coords.indexOf('+') + 1);

    ymaps.ready(init);
}

if (resultsQuantity === 0) {
    latitude = 55.76;
    longitude = 37.64;

    ymaps.ready(init);
}

$('.result').each(function () {
    if ($(this).find('h4').html() == latitude + ' ' + longitude) {
        $(this).css({
            'background-color':'lightgreen'
        })
    }
});
