function menu_download() {
    $('html, body').animate({
        scrollTop: $(".download").offset().top
    }, 1000);
}

function menu_news() {
    $('html, body').animate({
        scrollTop: $(".news").offset().top
    }, 1000);
}

function menu_about() {
    $('html, body').animate({
        scrollTop: $(".about").offset().top
    }, 1000);
}

function menu_home() {
    $('html, body').animate({
        scrollTop: $(".home").offset().top
    }, 2000);
}

function menu_docs() {
    $('html, body').animate({
        scrollTop: $(".docs").offset().top
    }, 1000);
}

function menu_support() {
    $('html, body').animate({
        scrollTop: $(".support").offset().top
    }, 1000);
}

function menu_gallery() {
    $('html, body').animate({
        scrollTop: $(".gallery").offset().top
    }, 1000);
}


var Alert1 = new CustomAlert();

function CustomAlert() {
    this.render1 = function() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverflow = document.getElementById('dialogoverflow');
        var dialogbox = document.getElementById('dialogbox');
        $("#dialogoverflow").fadeIn("100");
        dialogoverflow.style.height = winH + "px";
        dialogbox.style.left = (winW / 2) - (750 * .5) + "px";
        dialogbox.style.top = "75px";
        $("#dialogbox").slideDown("100");
    };
    this.ok = function() {
        $("#dialogbox").slideUp("100");
        $("#dialogoverflow").fadeOut("100");
    };
}


//2nd Messages
var Alert2 = new CustomAlert2();

function CustomAlert2() {
    this.render2 = function() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverflow2 = document.getElementById('dialogoverflow2');
        var dialogbox2 = document.getElementById('dialogbox2');
        $("#dialogoverflow2").fadeIn("100");
        dialogoverflow2.style.height = winH + "px";
        dialogbox2.style.left = (winW / 2) - (750 * .5) + "px";
        dialogbox2.style.top = "75px";
        $("#dialogbox2").slideDown("100");
    };
    this.ok2 = function() {
        $("#dialogbox2").slideUp("100");
        $("#dialogoverflow2").fadeOut("100");
    };
}


//3rd Requests
var Alert3 = new CustomAlert3();

function CustomAlert3() {
    this.render3 = function() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverflow3 = document.getElementById('dialogoverflow3');
        var dialogbox3 = document.getElementById('dialogbox3');
        $("#dialogoverflow3").fadeIn("100");
        dialogoverflow3.style.height = winH + "px";
        dialogbox3.style.left = (winW / 2) - (750 * .5) + "px";
        dialogbox3.style.top = "75px";
        $("#dialogbox3").slideDown("100");
    };
    this.ok3 = function() {
        $("#dialogbox3").slideUp("100");
        $("#dialogoverflow3").fadeOut("100");
    };
}


var Alert4 = new CustomAlert4();

function CustomAlert4() {
    this.render4 = function() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverflow4 = document.getElementById('dialogoverflow4');
        var dialogbox4 = document.getElementById('dialogbox4');
        $("#dialogoverflow4").fadeIn("100");
        dialogoverflow4.style.height = winH + "px";
        dialogbox4.style.left = (winW / 2) - (750 * .5) + "px";
        dialogbox4.style.top = "75px";
        $("#dialogbox4").slideDown("100");
    };
    this.ok4 = function() {
        $("#dialogbox4").slideUp("100");
        $("#dialogoverflow4").fadeOut("100");
    };
}


var Alert5 = new CustomAlert5();

function CustomAlert5() {
    this.render5 = function() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverflow5 = document.getElementById('dialogoverflow5');
        var dialogbox5 = document.getElementById('dialogbox5');
        $("#dialogoverflow5").fadeIn("100");
        dialogoverflow5.style.height = winH + "px";
        dialogbox5.style.left = (winW / 2) - (550 * .5) + "px";
        dialogbox5.style.top = "75px";
        $("#dialogbox5").slideDown("100");
    };
    this.ok5 = function() {
        $("#dialogbox5").slideUp("100");
        $("#dialogoverflow5").fadeOut("100");
    };
}

function toggleMenu() {
    if ($(".navbar").css('display') == 'none') {
        $(".navbar").css("display", "block");
    } else {
        $(".navbar").css("display", "none");
    }
}

$(document).ready(function() {
    console.log("meme");
    $("form#mail-subscribe").submit(function() {
        var surl = $(this).attr('action') + '?' + $(this).serialize();
        $.ajax({
            url: surl,
            dataType: "jsonp",
            jsonpCallback: function() {
                $('.message-mail').css("display", "block");
            }
        });
        return false;
    });
});