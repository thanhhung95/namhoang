/**
 *
 *  Phần xử lý hiển thị menu và fix độ cao của menu, content sao cho luôn = trình duyệt khi resize
 *
 */
$(document).ready(function () {
    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
    // ẩn hiện leftmenu
    $('.navbar-minimalize').on('click', function () {
        $("body").toggleClass("mini-navbar");
        $('.navbar-static-side').css('display','block');
        SmoothlyMenu();
    });
    // Full height of backgound
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebar-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarheight = $('nav.navbar-default').height();
        var wrapperHeight = $('#page-wrapper').height();

        if (navbarheight > wrapperHeight) {
            $('#page-wrapper').css("min-height", navbarheight + "px");
        }

        if (navbarheight < wrapperHeight) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarheight > wrapperHeight) {
                $('#page-wrapper').css("min-height", navbarheight + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 160 + "px");
            }
        }

    }

    fix_height();

    function fix_height_col_left(id,num) {
        $(id).css("max-height", $(window).height() - num + "px");
        $(id).css("height", $(window).height() - num + "px");
    }

    fix_height_col_left('#nhansuList',135);
    fix_height_col_left('#contentHeight',135);
    fix_height_col_left('#leftMenu',-16);  // Fix chiều cao của menu khi màn hình thay đổi

    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
        fix_height_col_left('#nhansuList',135);
        fix_height_col_left('#contentHeight',135);
        fix_height_col_left('#leftMenu',-16);
    });

    $("[data-toggle=popover]")
        .popover();


});

$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}
/**
 *
 *  Phần xử lý tìm kiếm tên nhân sự trên html
 *
 **/
$(document).ready(function(){
    var items               = null,    // chứa tất cả <li> trong <ul>
        item                = $(),                      // chứa 1 <li>
        items_LowerCase     = [];                       // chứa chuỗi nội dung của <li> và chuyển thành thường.


    //Tìm kiếm html trong danh sách nhân sự
    $('#html_search').keyup(function(){
        if(items == null){
            items               = $('.list-group-item');    // chứa tất cả <li> trong <ul>
            items.each(function () {
                items_LowerCase.push( $( this ).text().replace( /\s{2,}/g, ' ' ).toLowerCase() );
                item = $(this);
            });
        }

        var searchVal = $.trim($(this).val()).toLowerCase();

        if( searchVal.length )
        {
            for( var i in items_LowerCase )
            {
                item = items.eq( i );
                if( items_LowerCase[ i ].indexOf( searchVal ) != -1 )
                    item.removeClass( 'is-hidden' );
                else
                    item.addClass( 'is-hidden' );
            }
        }
        else items.removeClass( 'is-hidden' );

    });
    // hiệu ứng menu
    $('#side-menu li').click(function () {
        if($(this).hasClass('active')){
            $(this).toggleClass('active');
            $(this).children('ul').slideToggle(500);
        }
        else {
            $('#side-menu li.active').removeClass('active').children('ul').slideToggle(500);

            $(this).toggleClass('active');
            $(this).children('ul').slideToggle(500);
        }




    });
});

/**
 *
 * Load dữ liệu cho Modal Địa danh
 *
 **/

function getDiadanh(url,selector,seleted){
    $.ajax(
        url, // Lấy danh sách các quốc gia
        {
            type: 'GET',  // Kep one of your method
            success: function (data) {
                var html = seleted;
                data.forEach(function (item) {
                    html+='<option value="'+item.id+'">'+item.ten+'</option>';
                })
                $('select'+selector).html(html);
            },
            error: function (data) {
                console.log('lỗi load ajax: getDiadanh');
            }
        });
}
$(document).ready(function(){
    getDiadanh('api/diadanh/0','#diadanh_quocgia',''); // Lấy danh sách các quốc gia
    getDiadanh('api/diadanh/1','#diadanh_tinh','<option value="0">-- Chọn tỉnh --</option>'); // Lấy danh sách tỉnh thuộc quốc gia có id = 1
});
$(document).on('change','#diadanh_quocgia',function(){
    getDiadanh('api/diadanh/'+$(this).val(),'#diadanh_tinh','<option value="0">-- Chọn tỉnh/Thành --</option>');
    $('#diadanh_huyen').html('<option value="0">-- Chọn Huyện/Thị --</option>');
    $('#diadanh_xa').html('<option value="0">-- Chọn Huyện/Thị --</option>');
});
$(document).on('change','#diadanh_tinh',function(){
    getDiadanh('api/diadanh/'+$(this).val(),'#diadanh_huyen','<option value="0">-- Chọn Huyện/Thị --</option>');
    $('#diadanh_xa').html('<option value="0">-- Chọn Xã/Phường --</option>');
});
$(document).on('change','#diadanh_huyen',function(){
    getDiadanh('api/diadanh/'+$(this).val(),'#diadanh_xa','<option value="0">-- Chọn Xã/Phường --</option>');
});
