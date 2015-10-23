/**
 * Created by yuelei on 15/10/23.
 */
var App=function(){
    var handleMenu = function(){
        $('.sub-menu').on('click','li>a', function (e) {

            var parent = $(this).parent();
            $('.sub-menu li').each(function(){
                $(this).removeClass('activeMenu');
                $(this).parent().parent().removeClass('active');
            });

            parent.addClass('activeMenu');
            var sub_menu_ul = parent.parent();
            sub_menu_ul.parent().addClass('active');
            //e.preventDefault();
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
        $(this).parent().addClass('active');
    });
    $('.collapse').on('hide.bs.collapse',function(){
        $(this).parent().removeClass('active');
    })
})
