function esconderAlerta(div){
    $("#"+div).fadeOut(1600);
}

function moneyFormat(number){
    const options = { style: 'currency', currency: 'MXN' };
    const numberFormat = new Intl.NumberFormat('es-MX', options);

    return numberFormat.format(number);
}

function formatearMoneda(valor, options = {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
}) {
    return Number(valor).toLocaleString('es-MX', options)
}

function validarRangoInputsNumber(event) {
    const target = event.target ?? event.currentTarget ?? event.srcElement;

    if (target.min !== "") {
        if (Number(target.value) <= Number(target.min)) {
            target.value = target.min;
        }
    }

    if (target.max !== "") {
        if (Number(target.value) > Number(target.max)) {
            target.value = target.max;
        }
    }
}

function validateInput(event) {
    const element = event.target ?? event.currentTarget ?? event.srcElement;

    if ((element.value === '') && (element.required === true)) {
        element.classList.add("is-warning");
        element.classList.remove("is-valid", "is-invalid");
    } else {
        if (element.disabled === true) {
            element.classList.remove("is-valid", "is-invalid", "is-warning");
        } else {    
            if (element.validity.valid === true) {
                element.classList.add("is-valid");
                element.classList.remove("is-invalid", "is-warning");
            } else {
                element.classList.add("is-invalid");
                element.classList.remove("is-valid", "is-warning");
            }
        }
    }
}

function basicValidation() {
    const wrapper = document.querySelector("body > .wrapper > .content-wrapper");

    const __inputs = wrapper.querySelectorAll("input[type='text']:enabled,input[type='number']:enabled,input[type='file']:enabled,input[type='date']:enabled,textarea:enabled,input[type='datetime-local']:enabled");
    const __selects = wrapper.querySelectorAll("select");

    const elements = [...__inputs, ...__selects];

    for (const element of elements) {
        if (element.name === '') {
            continue;
        }

        const bvAttribute = element.getAttribute("data-basic-validation");
        if ((bvAttribute !== null) && (Boolean(bvAttribute) === true)) {
            continue;
        }

        element.setAttribute("data-basic-validation", "true");

        const changeEvent = new Event("change");

        element.addEventListener("change", (event) => {
            validateInput(event);
        });

        element.dispatchEvent(changeEvent);
    }
}

function  generateRandomString(num) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    
    let result = '';
    
    for ( let i = 0; i < num; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
  
    return result;
};

function handleImgLoad(event) {
    const img = event.target;

    if (img.getAttribute("tryHandleImgLoad") === null) {
            img.setAttribute("tryHandleImgLoad", "true");
        
            img.src = "./assets/img/placeholder-image.webp";
            img.alt = "Placeholder imagen";
        
            event.preventDefault();
    }
}

function normalizarTexto(string) {
    const regexAcentosNFD = /[\u0300-\u036f]/g;
    const regexSoloLetras = /[^a-zA-Z ]/g;
    const regexEspaciosExtra = / + /g;

    let nuevoString = string
        .normalize('NFD')
        .replace(regexAcentosNFD,"")
        .replace(regexSoloLetras, "")
        .trim()
        .replace(regexEspaciosExtra, " ")
        .replaceAll(" ", "_")
        .toLowerCase();

    // Aquí es importante el orden de las funciones
    return nuevoString;
}

function formatearBytes(bytes) {
    const lista = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

    if (bytes == 0) return '0 Byte';

    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + lista[i];
}