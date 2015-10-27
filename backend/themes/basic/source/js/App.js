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
        //$(this).parent().addClass('activeMenu');
    });
    $('.collapse').on('hide.bs.collapse',function(){
        //$(this).parent().removeClass('activeMenu');
    })
})
