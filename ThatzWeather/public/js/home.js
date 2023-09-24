var valor = document.getElementById("homeInput");
var errorText = document.getElementById("errorText");
function validarHome(){
    if(!(/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/.test(valor.value))||valor.value.length == 0){
        errorText.style.visibility = "visible";
        valor.classList.add("homeInputError");
        return false;
    }
    errorText.style.visibility = "hidden";
    valor.classList.remove("homeInputError");
    return true;
}
valor.addEventListener("focus",() => { valor.classList.remove("homeInputError"); errorText.style.visibility = "hidden";});
valor.addEventListener("blur",() => { validarHome() });