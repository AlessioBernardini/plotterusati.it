$(function(){

    var target_date = $('#countdown').data('target-date');
    var days, hours, minutes, seconds;
    var countdown = document.getElementById('countdown');
    
    setInterval(function () {
     
        var current_date = new Date().getTime();
        var seconds_left = target_date - (current_date / 1000);
        var time_left = seconds_left;

        days = parseInt(seconds_left / 86400);
        seconds_left = seconds_left % 86400;
         
        hours = parseInt(seconds_left / 3600);
        seconds_left = seconds_left % 3600;
         
        minutes = parseInt(seconds_left / 60);
        seconds = parseInt(seconds_left % 60);

        if(time_left > -1){
            countdown.innerHTML = '';

            if(days == 1)
                countdown.innerHTML += '<span class="text-danger"><b>' + days +  '</b></span> Day ';
            else if (days > 0)
                countdown.innerHTML += '<span class="text-danger"><b>' + days +  '</b></span> Days ';

            if(hours == 1)
                countdown.innerHTML += '<span class="text-danger"><b>' + hours + '</b></span> hour ';
            else if (hours > 0)
                countdown.innerHTML += '<span class="text-danger"><b>' + hours + '</b></span> hours ';    

            if(days < 1){

                if(minutes == 1)
                    countdown.innerHTML += '<span class="text-danger"><b>' + minutes + '</b></span> minute '
                else if (minutes > 0)
                    countdown.innerHTML += '<span class="text-danger"><b>' + minutes + '</b></span> minutes '
                
                if(seconds == 1)
                    countdown.innerHTML += '<span class="text-danger"><b>' + seconds + '</b></span> second';  
                else if (seconds > -1)
                    countdown.innerHTML += '<span class="text-danger"><b>' + seconds + '</b></span> seconds'; 
            }

        } else if (time_left == 0 || time_left < 0) {
            countdown.innerHTML = '<span class="text-danger"><b>0</b></span> seconds'; 
        }
     
    }, 1000);
});