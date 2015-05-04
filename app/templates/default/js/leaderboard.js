
$(document).ready(leaderboard());
function leaderboard() {
    $.get(
        'http://retrogaming.zone/leaderboard/update?d=' + Date.now(),
        function (data) {
            for (i = 0; i < data.length; i++) {
                if ($('#user-' + data[i].id).length == 0) {
                    // this id doesn't exist, so add it to our list.
                    $("#leaderboard").append('<li id="user-' + data[i].id + '"><h3>' + data[i].name +
                    '</h3><span>' + data[i].games + '</span></li>');
                } else {
                    // this id does exist, so update 'score' count in the h1 tag in the list item.
                    $('#user-' + data[i].id + ' span').html(data[i].games);
                }
            }
            var $Ul = $('ul#leaderboard');
            $Ul.css({position:'relative',height:$Ul.height(),display:'block'});
            var iLnH;
            var $Li = $('ul#leaderboard>li');
            $Li.each(function(i,el){
                var iY = $(el).position().top;
                $.data(el,'h',iY);
                if (i===1) iLnH = iY;
            });
            $Li.tsort('span',{order:'desc'}).each(function(i,el){
                var $El = $(el);
                var iFr = $.data(el,'h');
                var iTo = i*iLnH;
                $El.css({position:'absolute',top:iFr}).animate({top:iTo},500);
            });
        },
        'json'
    );

    t = setTimeout("leaderboard()", 1500);
}