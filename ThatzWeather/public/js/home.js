valor = document.getElementById("homeInput");
function validarHome(){
    if(!(/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/.test(valor.value))||valor.value.length == 0){
        console.log(valor)
        valor.classList.add("homeInputError");
        return false;
    }
    valor.classList.remove("homeInputError");
    return true;
}
valor.addEventListener("focus",() => { valor.classList.remove("homeInputError") });
valor.addEventListener("blur",() => { validarHome() });