$(document).ready(function() {
    var examplePassword = generatePassword();

    $('#registerpanel .field input').each(function () {
        if ($(this).val().length > 0) {
            $(this).siblings("label").addClass("active");
        }
    });

    $(document).on("click", '#page-title', function(e) {
        var base = $("base").attr("href");
        window.open(base, "_self");
    });
    $(document).on("click", '#registerpanel .tab li', function(e) {
        if(!$(this).hasClass("selected")) {
            $("#regtype").attr("value", (Number($("#regtype").attr("value")) == 1)?0:1);
            $("#registerpanel .tab li").toggleClass("selected");
            $("#registerpanel .fields").toggleClass("switched");
            $("#register").trigger("reset");
            $("#register input[type=text], #register input[type=email], #register input[type=password], #register input[type=tel]").val("");
            $("#registerpanel .field .placeholder").removeClass("focus active");
            $("#registerpanel .field select").removeClass("active");
            examplePassword = generatePassword();
            $("#registerpanel .field .help.password").html("Pl.: " + examplePassword);
        }
    });

    $(document).on("focus", '#registerpanel .field input', function(e) {
        $(this).siblings("label").addClass("focus active");
    });

    $(document).on("change keyup", '#registerpanel .field input', function(e) {
        $(this).siblings("label").addClass("active");
    });

    $(document).on("change", '#registerpanel .field select', function(e) {
        $(this).parent().siblings("label").addClass("active");
        $(this).addClass("active");
    });

    $(document).on("focusout", '#registerpanel .field input', function(e) {
        $(this).siblings("label").removeClass("focus");
        if(!$(this).val().length) {
            $(this).siblings("label").removeClass("active");
        }
    });

    $(document).on("focus", '#registerpanel .field select', function(e) {
        $(this).parent().addClass("focus");
        $(this).parent().siblings("label").addClass("focus");
    });

    $(document).on("focusout", '#registerpanel .field select', function(e) {
        $(this).parent().removeClass("focus");
        $(this).parent().siblings("label").removeClass("focus");
    });

    $("#registerpanel .help.password").html("Pl.: " + examplePassword);

    $(document).on("focus", '#loginpanel input', function(e) {
        $(this).siblings("div").addClass("focus");
    });
    $(document).on("blur", '#loginpanel input', function(e) {
        $(this).siblings("div").removeClass("focus");
    });

    $(document).on("click", '#menubutton', function() {
        $("nav").toggleClass("mobileshow");
    });

    $(document).on("click", 'nav .frame', function() {
        $("nav").removeClass("mobileshow");
    });
});


function generatePassword() {
    var	length = Math.floor(8 + Math.random() * 8),
        charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,.-_(){}[]/*",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

