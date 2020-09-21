window.onload = function() {
    var canvas = document.createElement("canvas");

    var pic = new Image(); 
    pic.crossOrigin = "Anonymous";
	pic.src = $('#logo img').attr('src');
    pic.onload = function() {

        canvas.width = pic.width;
        canvas.height = pic.height;
        var ctx = canvas.getContext("2d");

        ctx.drawImage(pic, 0, 0);

        var c = canvas.getContext('2d');
        var color1 = c.getImageData(pic.width*0.25, pic.height*0.25, 1, 1).data;
        var color2 = c.getImageData(pic.height*0.5, pic.height*0.5, 1, 1).data;
        var color3 = c.getImageData(pic.height*0.75, pic.height*0.75, 1, 1).data;

        console.log("Dark: "+getDarkest(color1, color2, color3));
        console.log("Light: "+getLightest(color1, color2, color3));
        console.log("Middle: "+getMiddleColor(color1, color2, color3));

        $("a").css("color", rgbToHex(getMiddleColor(color1, color2, color3)));
        $("a").hover(
        function() {
            $(this).css('color', rgbToHex(getDarkest(color1, color2, color3)))
        }, function() {
            $(this).css('color', rgbToHex(getMiddleColor(color1, color2, color3)))
        });
        

        
        $("nav.navbar.navbar-default").css("background-color", rgbToHex(getLighter(getDarkest(color1, color2, color3), 2)));
        $("nav.navbar.navbar-default").css("border-color", rgbToHex(getLightest(color1, color2, color3)));




    }
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

// converts rgb to hex
function rgbToHex(rgb) {
    return "#"+componentToHex(rgb[0])+componentToHex(rgb[1])+componentToHex(rgb[2]);
}

// returns darkest color
function getDarkest(c1, c2, c3) {
    col1 = c1[0]*1000000+c1[1]*1000+c1[2];
    col2 = c2[0]*1000000+c2[1]*1000+c2[2];
    col3 = c3[0]*1000000+c3[1]*1000+c3[2];
    
    if(col1 <= col2 && col1 <= col3){
        return c1;
    } else if (col2 <= col1 && col2 <= col3) {
        return c2;
    } else {
        return c3;
    }
}

// returns lightest color
function getLightest(c1, c2, c3) {
    col1 = c1[0]*1000000+c1[1]*1000+c1[2];
    col2 = c2[0]*1000000+c2[1]*1000+c2[2];
    col3 = c3[0]*1000000+c3[1]*1000+c3[2];
    
    if(col1 >= col2 && col1 >= col3){
        return c1;
    } else if (col2 >= col1 && col2 >= col3) {
        return c2;
    } else {
        return c3;
    }
}

// returns middle color
function getMiddleColor(c1, c2, c3) {
    col1 = c1[0]*1000000+c1[1]*1000+c1[2];
    col2 = c2[0]*1000000+c2[1]*1000+c2[2];
    col3 = c3[0]*1000000+c3[1]*1000+c3[2];
    
    if((col1 >= col2 && col1 <= col3) || (col1 <= col2 && col1 >= col3)){
        return c1;
    } else if ((col2 >= col1 && col2 >= col3) || (col2 <= col1 && col2 >= col3)) {
        return c2;
    } else {
        return c3;
    }
}

// returns ligher color than the given
function getLighter(color, percentage) {
    color[0] = color[0]*percentage;
    color[1] = color[1]*percentage;
    color[2] = color[2]*percentage;
    return color;
}

