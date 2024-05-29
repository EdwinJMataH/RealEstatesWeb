const modalDimensions = {
    width: '90vw', // Ancho del 90% del viewport
    maxWidth: '640px', // Ancho máximo de 640px
    '@screen md': {
        width: '80vw', // Ancho del 80% del viewport para pantallas medianas
        maxWidth: '768px' // Ancho máximo de 768px para pantallas medianas
    },
    '@screen lg': {
        width: '70vw', // Ancho del 70% del viewport para pantallas grandes
        maxWidth: '1024px' // Ancho máximo de 1024px para pantallas grandes
    },
    '@screen xl': {
        width: '60vw', // Ancho del 60% del viewport para pantallas extra grandes
        maxWidth: '1280px' // Ancho máximo de 1280px para pantallas extra grandes
    }
}

const validateEmail = (email) => {
    let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    // return regex.test(String(email).toLowerCase());
    return {
        status: regex.test(String(email).toLowerCase()),
        alert: { severity: 'error', detail: messages['error-email'] },
    }
}

const isEmpty = (value) => {
    return value == null || value.length === 0;
}

function getModulesMenu(module){

    let modules = {
        profile: {
            label: 'Pefil',
            icon: 'pi pi-user',
            route: 'profile.edit',
            orderBy: 1
        },
        users: {
            label: 'Usuarios',
            icon: 'pi pi-users',
            route: 'users.index',
            orderBy: 2
        },
        dashboard: {
            label: 'Sign Out',
            icon: 'pi pi-sign-out',
            orderBy: 3
        }
    }
    if (module) {
        return modules[module];
    }
}


const messages = {
    'error-email'     : 'El correo electrónico proporcionado, no corresponde a uno válido.',
    'error-phone'     : 'El número de celular proporcionado, no corresponde a uno válido.',
    'error-passwords' : 'Las contraseñas proporcionadas, no coinciden.',
    'form-empty'      : 'Se han encontrado campos vacíos en el formulario. Por favor, llenarlos.',
    'uuid-not-found'  : 'Ha ocurrido un problema al consultar la información solicitada.',
    'get-success'     : 'Se ha obtenido la información correctamente.',
    'update-success'  : 'Se ha realizado la actualización correctamente.',
    'register-success': 'Se ha realizado el registro correctamente.',
    'delete-success'  : 'Se ha realizado el borrado correctamente.',
    'get-error'       : 'Ha ocurrido un problema al obtener la información solicitada.',
    'update-error'    : 'Ha ocurrido un problema con la actualización.',
    'register-error'  : 'Ha ocurrido un problema con el registro.',
    'delete-error'    : 'Ha ocurrido un problema con el borrado.',
    'image-error'     : 'Ha ocurrido un problema con el regstro de la imagen.',
    'error'           : 'El servidor encontró un error inesperado. Por favor, inténtalo de nuevo más tarde.',
}

const getResponse = (response) => {
    const { status, message, data } = response;
    let error    = messages.error;
    let severity = 'success';
    let detail   = message ?? error;

    if (!status) severity = 'error';

    return { severity, detail, status, data }
}

const validateFormIsEmpty = (object) => {
    return {
        status: !Object.keys(object).some(element => isEmpty(object[element])),
        alert: { severity: 'warn', detail: messages['form-empty']},
    }
};

const validateSamePasword = (object) => {
    return {
        status: object.password == object.password_confirmation,
        alert: { severity: 'warn', detail: messages['error-passwords']},
    }
};







export {
    modalDimensions,
    validateEmail,
    isEmpty,
    getResponse,
    messages,
    getModulesMenu,
    validateFormIsEmpty,
    validateSamePasword
};
