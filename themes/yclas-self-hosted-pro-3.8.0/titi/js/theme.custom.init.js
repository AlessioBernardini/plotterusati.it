// v3.1.0
//Docs at http://simpleweatherjs.com
$(document).ready(function() {
  $.simpleWeather({
    location: 'Port of Spain, Trinidad and Tobago',
    woeid: '',
    unit: 'c',
    success: function(weather) {
      html = '<span><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</span>';
  
      $("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
  displayTime();
});

function displayTime() {
    var time = moment().tz("America/Port_of_Spain").format('MMMM Do YYYY, h:mm:ss a');
    $('#currentTime').html(time);
    setTimeout(displayTime, 1000);
}

$('.swipebox').swipebox();

$('.slider_search').slider();
$('.slider_search').slider()
    .on('slideStop', function(e) {
        $("input[name='price-min']").val(e.value[0]);
        $("input[name='price-max']").val(e.value[1]);
});