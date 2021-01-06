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