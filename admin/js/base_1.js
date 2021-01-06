$(document).ready(function(){
    $('.conthtml').css('min-height', $(document).height());
    size(0);
    $('.ti').click(function(){
        var id = $(this).attr('id');
        if($('.nav').width() == 180){
            $(this).parents('.lt').find('.tooltip').hide();
            if($(this).parents('.lt').find('ul').is(':visible')){
                $(this).parents('.lt').find('ul').slideUp(500);
                var that = $(this);
                setTimeout(function(){ that.css('background', 'none'); }, 500);
            }else{
                $(this).parents('.lt').find('ul').slideDown(500);
                $(this).css('background', '#272727');
            }
        }
    });
    $('.lt').hover(function(){
        if(!$(this).find('ul').is(':visible')){
            var top = $(this).position().top;
            var left = $('.nav').width() - 20;
            var tooltip = $(this).find('.tooltip');
            tooltip.show();
            tooltip.css("top", top+"px");
            tooltip.css("left", left+"px");
        }
    }, function(){
        var tooltip = $(this).find('.tooltip');
        tooltip.hide();
    });
    $('.user-guide').hover(function(){
        $(this).find('.user-info').slideDown();
    }, function(){
        $(this).find('.user-info').slideUp();
    });
    
    $('.mas').click(function(){

        if($(this).find('h4').html() == "+"){
            $(this).find('h4').html("-");
            $(this).find(".masinfo").slideDown();
        }else{
            $(this).find('h4').html("+");
            $(this).find(".masinfo").slideUp();
        }
        
    });
    localStorage.setItem("history", null);
    /*
    $('.claves').sortable({
        stop: function(e, ui){
            var order = [];
            $(this).find('.clave').each(function(){
                order.push($(this).find('h2').html());
            });
        }
    });
    $('.claves').disableSelection();
    */
   
});

function mascoord(){
    
    var cant = parseInt($('#cantpts').val())+1;
    $('.listinput').append('<label><span>Latitud '+cant+':</span><input id="lat'+cant+'" type="text" value="" /></label><label><span>Longitud '+cant+':</span><input id="lng'+cant+'" type="text" value="" /></label>');
    $('#cantpts').val(cant);
    
}
$(window).resize(function() {
    size(1);
});

function size(m){
    var num = 920;
    var width = $( window ).width();
    if(m == 0){
        if(width < num){
            $('#navw').val(0);
            $('.nav').css("width", "40px");
            $('.cont').css("margin-left", "40px");
        }else{
            $('#navw').val(1);
            $('.nav').css("width", "180px");
            $('.cont').css("margin-left", "180px");
        }
    }
    if(width < num && $('#navw').val() == 1){
        $('#navw').val(0);
        $('.nav').css("width", "40px");
        $('.cont').css("margin-left", "40px");
        $('.navlist').find('.lt').each(function(){
            var ul = $(this).find('ul');
            if(ul.is(':visible')){
                ul.hide();
                ul.addClass('mm');
            }
        });
    }
    if(width > num && $('#navw').val() == 0){
        $('#navw').val(1);
        $('.nav').css("width", "180px");
        $('.cont').css("margin-left", "180px");
        $('.navlist').find('.mm').show();
        $('.navlist').find('.mm').removeClass('mm');
    }
}


function topscroll(){
    $('html, body').animate({ scrollTop: 0 }, 500);
}
function backurl(){
    
    var history = JSON.parse(window.localStorage.getItem("history"));
    var len = history.length;
    var i = 1;
    if(len > 1){
        history.pop();
        i++;
    }
    navlinks(history[len - i]);
    localStorage.setItem("history", JSON.stringify(history));
    
}
function addhistorylink(url){
    
    var history = JSON.parse(window.localStorage.getItem("history"));
    if(history == null){
        history = new Array();
    }
    history.push(url);
    localStorage.setItem("history", JSON.stringify(history));
    
}
function navlink(href){
    
    addhistorylink(href);
    topscroll();
    $.ajax({
        url: href,
        type: "POST",
        data: "",
        beforeSend: function(){
            $(".loading").show();
            $(".error").hide();
        },
        success: function(data, status){
            $(".conthtml").html(data);
            $(".loading").hide();
        },
        error: function(){
            $(".error").show();
            $(".loading").hide();
        },
        complete: function(){
            
            
        }
    });
    return false;
}
function navlinks(href){

    topscroll();
    $.ajax({
        url: href,
        type: "POST",
        data: "",
        beforeSend: function(){
            $(".loading").show();
            $(".error").hide();
        },
        success: function(data, status){
            $(".conthtml").html(data);
            $(".loading").hide();
        },
        error: function(){
            $(".error").show();
            $(".loading").hide();
        },
        complete: function(){
            
            
        }
    });
    return false;
}
function eliminar(accion, id, tipo, name){

    var msg = {
        title: "Eliminar "+tipo, 
        text: "Esta seguro que desea eliminar a "+name, 
        confirm: "Si, deseo eliminarlo",
        name: name,
        accion: accion,
        id: id,
    };

    confirm(msg);
        
}

function confirm(message){
    
    swal({   
        title: message['title'],   
        text: message['text'],   
        type: "error",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: message['confirm'],   
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function(isConfirm){

        if(isConfirm){
            
            var send = {accion: message['accion'], id: message['id'], nombre: message['name']};
            console.log(send);
            $.ajax({
                url: "ajax/index.php",
                type: "POST",
                data: send,
                success: function(data){
                    
                    console.log(data);
                    setTimeout(function(){  
                        swal({
                            title: data.titulo,
                            text: data.texto,
                            type: data.tipo,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        if(data.reload)
                            navlinks('pages/'+data.page);
                    }, 10);

                }, error: function(e){
                    console.log(e);
                }
            });
 
        }
        
    });
    
}
function openwn(url, w, h){
    var myWindow = window.open(url, "_blank", "width="+w+",height="+h);
}
function opcs(that, name){
    var ss = $(that).parents('.ss');
    var op = $(that).parents('.op');
    if(op.hasClass('isview')){
        op.css({width: '30px'});
        op.removeClass('isview');
        ss.find('li').eq(0).hide();
    }else{
        var fc = $(that).parents('.fc');
        op.css({width: '150px'});
        op.addClass('isview');
        ss.find('li').eq(0).fadeIn();
        if(ss.find('.inptxt').length){
            ss.find('.inptxt').bind('keyup', function(e){
                search(ss.find('input').val().toLowerCase(), fc, name);
            });
        }
        if(ss.find('.inpsel').length){
            ss.find('.inpsel').bind("change", function(){
                search(ss.find('.inpsel option:checked').val(), fc, name);
            });
        }

    }
}
function search(inputval, fc, name){   
    fc.find('.listUser').find('.user').each(function(){
        var nombre = $(this).find('.nombre').attr(name).toLowerCase();
        if (nombre.indexOf(inputval) != -1 || inputval == -1){
            $(this).show();
        }else{
            $(this).hide();
        }
    });
}
function setadmin(id_sis){
    
    var send = {accion: "setadmin", id_sis: id_sis};
    $.ajax({
        url: "ajax/index.php",
        type: "POST",
        data: send,
        success: function(data){
            
            location.reload();
            
        }
    });
    return false;
    
}


function salir(){
    
    var send = {accion: "salir"};
    $.ajax({
        url: "ajax/index.php",
        type: "POST",
        data: send,
        success: function(data){
            
            location.reload();
            
        }
    });
    return false;
}