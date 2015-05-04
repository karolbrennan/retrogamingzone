/**
 * Created by karolbrennan on 12/11/14.
 */

$(document).ready(function() {
    $("#filter-results select").change(function() {
       $("#filter-results").submit();
    });

    $('.games .game-collection').on('click','.addgametocollection a', addGameToCollection);
    $('.games .game-wishlist').on('click','.addgametowishlist a', addGameToWishlist);

    $('.games .game-collection').on('click','.removegamefromcollection a', removeGameFromCollection);
    $('.games .game-wishlist').on('click','.removegamefromwishlist a', removeGameFromWishlist);

    $('.consoles .console-collection').on('click','.addconsoletocollection a', addConsoleToCollection);
    $('.consoles .console-wishlist').on('click','.addconsoletowishlist a', addConsoleToWishlist);

    $('.consoles .console-collection').on('click','.removeconsolefromcollection a', removeConsoleFromCollection);
    $('.consoles .console-wishlist').on('click','.removeconsolefromwishlist a', removeConsoleFromWishlist);
});

$.ajaxSetup({cache: false});

function addGameToCollection(){
    var gameid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/collection/addgame', // url of PHP file doing the work
        {gameid: gameid}, 	// pass the array of data we want to send to the PHP file
        function(data) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href="/login";
                return true;
            } else {
                // change icon to a spinner to show that it's "working" on the request
                $('.addgametocollection .' + gameid + ' i').attr('class', 'fa fa-spin fa-spinner');
                // if already in wishlist, it'll change that icon as well
                $('.removegamefromwishlist .' + gameid + ' i').attr('class', 'fa fa-spin fa-spinner');
                // set a timeout before swapping to the new icon
                setTimeout(function () {
                    $('.removegamefromcollection .' + gameid + ' i').attr('class', 'fa fa-check');
                    // if swapping between collection and wishlist, change the icon for the other option as this is a toggle.
                    $('.removegamefromwishlist').attr('class', 'addgametowishlist');
                    $('.addgametowishlist .' + gameid + ' i').attr('class', 'fa fa-gift');
                }, 500);
                $('.addgametocollection .' + gameid).parent().attr('class', 'removegamefromcollection');

                if (data) {
                    var achievement = dataObject;
                    var title = achievement[0].achievement_title;
                    var description = achievement[0].achievement_text;
                    var badge = achievement[0].achievement_badge;

                    $('#achievement').css('display', 'block', 'opacity', '1');
                    $('.achievement-overlay').css('opacity', '1');
                    $("#achievement-content").html(
                        "<h2>" + title + "</h2>" +
                        "<img src='http://retrogaming.zone/app/templates/default/images/badges/" + badge +
                        "' alt='" + title + "'><br>" + "<p>" + description + "</p>"
                    );
                    $("#achievement").click(function () {
                        $('#achievement').hide()
                    });
                }
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}

function addConsoleToCollection(){
    var consoleid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/collection/addconsole', // url of PHP file doing the work
        {consoleid: consoleid}, 	// pass the array of data we want to send to the PHP file
        function( data ) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href = "/login";
                return true;
            } else {
                // change icon to a spinner to show that it's "working" on the request
                $('.addconsoletocollection .' + consoleid + ' i').attr('class', 'fa fa-spin fa-spinner');
                $('.removeconsolefromwishlist .' + consoleid + ' i').attr('class', 'fa fa-spin fa-spinner');
                // set a timeout before swapping to the new icon
                setTimeout(function () {
                    $('.removeconsolefromcollection .' + consoleid + ' i').attr('class', 'fa fa-check');
                    // if swapping between collection and wishlist, change the icon for the other option as this is a toggle.
                    $('.removeconsolefromwishlist').attr('class', 'addconsoletowishlist');
                    $('.addconsoletowishlist .' + consoleid + ' i').attr('class', 'fa fa-gift');
                }, 500);
                $('.addconsoletocollection .' + consoleid).parent().attr('class', 'removeconsolefromcollection');
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}

function removeGameFromCollection(){
    var gameid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/collection/removegame', // url of PHP file doing the work
        {gameid: gameid}, 	// pass the array of data we want to send to the PHP file
        function( data ) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href = "/login";
                return true;
            }
            else {
                $('.removegamefromcollection .' + gameid + ' i').attr('class', 'fa fa-spin fa-spinner');
                setTimeout(function () {
                    $('.addgametocollection .' + gameid + ' i').attr('class', 'fa fa-book');
                }, 500);
                $('.removegamefromcollection .' + gameid).parent().attr('class', 'addgametocollection');
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}

function removeConsoleFromCollection(){
    var consoleid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/collection/removeconsole', // url of PHP file doing the work
        {consoleid: consoleid}, 	// pass the array of data we want to send to the PHP file
        function( data ) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href = "/login";
                return true;
            }
            else {
                $('.removeconsolefromcollection .' + consoleid + ' i').attr('class', 'fa fa-spin fa-spinner');
                setTimeout(function () {
                    $('.addconsoletocollection .' + consoleid + ' i').attr('class', 'fa fa-book');
                }, 500);
                $('.removeconsolefromcollection .' + consoleid).parent().attr('class', 'addconsoletocollection');
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}


function addGameToWishlist(){
    var gameid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/wishlist/addgame', // url of PHP file doing the work
        {gameid: gameid}, 	// pass the array of data we want to send to the PHP file
        function( data) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href = "/login";
                return true;
            }
            else {
                // change icon to a spinner to show that it's "working" on the request
                $('.addgametowishlist .' + gameid + ' i').attr('class', 'fa fa-spin fa-spinner');
                $('.removegamefromcollection .' + gameid + ' i').attr('class', 'fa fa-spin fa-spinner');
                // set a timeout before swapping to the new icon
                setTimeout(function () {
                    $('.removegamefromwishlist .' + gameid + ' i').attr('class', 'fa fa-check');
                    // if swapping between collection and wishlist, change the icon for the other option as this is a toggle.
                    $('.removegamefromcollection').attr('class', 'addgametocollection');
                    $('.addgametocollection .' + gameid + ' i').attr('class', 'fa fa-book');
                }, 500);
                $('.addgametowishlist .' + gameid).parent().attr('class', 'removegamefromwishlist');
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}

function addConsoleToWishlist(){
    var consoleid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/wishlist/addconsole', // url of PHP file doing the work
        {consoleid: consoleid}, 	// pass the array of data we want to send to the PHP file
        function( data ) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href = "/login";
                return true;
            }
            else {
                // change icon to a spinner to show that it's "working" on the request
                $('.addconsoletowishlist .' + consoleid + ' i').attr('class', 'fa fa-spin fa-spinner');
                $('.removeconsolefromcollection .' + consoleid + ' i').attr('class', 'fa fa-spin fa-spinner');
                // set a timeout before swapping to the new icon
                setTimeout(function () {
                    $('.removeconsolefromwishlist .' + consoleid + ' i').attr('class', 'fa fa-check');
                    // if swapping between collection and wishlist, change the icon for the other option as this is a toggle.
                    $('.removeconsolefromcollection').attr('class', 'addconsoletocollection');
                    $('.addconsoletocollection .' + consoleid + ' i').attr('class', 'fa fa-book');
                }, 500);
                $('.addconsoletowishlist .' + consoleid).parent().attr('class', 'removeconsolefromwishlist');
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}

function removeGameFromWishlist(){
    var gameid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/wishlist/removegame', // url of PHP file doing the work
        {gameid: gameid}, 	// pass the array of data we want to send to the PHP file
        function( data ) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href = "/login";
                return true;
            }
            else {
                $('.removegamefromwishlist .' + gameid + ' i').attr('class', 'fa fa-spin fa-spinner');
                setTimeout(function () {
                    $('.addgametowishlist .' + gameid + ' i').attr('class', 'fa fa-gift');
                }, 500);
                $('.removegamefromwishlist .' + gameid).parent().attr('class', 'addgametowishlist');
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}

function removeConsoleFromWishlist(){
    var consoleid = $(this).attr('class');
    $.get(
        'http://retrogaming.zone/manage/wishlist/removeconsole', // url of PHP file doing the work
        {consoleid: consoleid}, 	// pass the array of data we want to send to the PHP file
        function( data ) {
            var dataObject = {};
            if(data) {
                dataObject = $.parseJSON(data)
            }
            if( dataObject['redirect'] ) {
                window.location.href = "/login";
                return true;
            }
            else {
                $('.removeconsolefromwishlist .' + consoleid + ' i').attr('class', 'fa fa-spin fa-spinner');
                setTimeout(function () {
                    $('.addconsoletowishlist .' + consoleid + ' i').attr('class', 'fa fa-gift');
                }, 500);
                $('.removeconsolefromwishlist .' + consoleid).parent().attr('class', 'addconsoletowishlist');
            }
        },
        'text' // the data type of the result (ie. html, text, xml, json, etc.)
    );

    return false;
}

