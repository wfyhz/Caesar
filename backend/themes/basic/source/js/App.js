/**
 * Created by yuelei on 15/10/23.
 */
var App=function(){
    var handleMenu = function(){
        $('#main-nav').on('click', 'li>a',function(){
            $('#main-nav a').each(function(){
                $(this).removeClass('activeMenu')
            });
            $(this).addClass('activeMenu');
        })
    };
    return {
        init:function(){
            handleMenu();
        }
    };
}();

$(document).ready(function(){
    App.init();
    $('.collapse').on('show.bs.collapse',function(){
        var s = $(this).parent().children('a').children('span');
        if(s != 'undefined')
        {
            s.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }
    });
    $('.collapse').on('hide.bs.collapse',function(){
        var s = $(this).parent().children('a').children('span');
        if(s != 'undefined')
        {
            s.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
    })
})
