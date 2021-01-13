var carr = 1;
function tooglemenu(that){
    that.parentElement.classList.toggle("close");
}
function next(n){
    docClass('fo'+carr).style.display = "none";
    carr = carr + n;
    if(carr == 0){ carr = 3 }
    if(carr == 4){ carr = 1 }
    docClass('fo'+carr).style.display = "block";
}
function docClass(n, i = 0){ return document.getElementsByClassName(n)[i] }
function cotizar(id, cant){
    $.ajax({
        url: "https://www.usinox.cl/ajax/index.php",
        type: "POST",
        data: "accion=cotizar&id="+id+"&cant="+cant,
        success: function(data){
            $('.item a').html(data.count + " item");
            if(data.url)
                window.location.href = data.url;
        }
    });
    return false;
}