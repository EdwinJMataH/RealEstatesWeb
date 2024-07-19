import { useStoreSpinner } from "@/Components/Spinner/Store/useStoreSpinner.js";
const storeSpinner = useStoreSpinner();
const { visible } = storeToRefs(storeSpinner);
import es from './locales/es.json'

function translate(key) {
    if (!key) return '-';

    let word = es[key] || key;
    return word.charAt(0).toUpperCase() + word.slice(1);
}


function spinner(show = true){
    if (show) {
        storeSpinner.show();
    } else {
        setTimeout(() => {
            storeSpinner.hidden();
        }, 1500);
    }
}


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
        alert: { severity: 'error', detail: messages['error_email'] },
    }
}

const isEmpty = (value) => {
    return value == null || value.length === 0;
}

const fetchAPI = async (object, functionCallback) => {
    spinner();
    let severity, detail, status, data;
    const { method = 'post', to, send = {}, parameter = {} } = object;

    try {
        const response = await axios({
            method: method,
            url: route(to, parameter),
            data: send
        });

        ({ severity, detail, status, data = [] } = getResponse(response.data));

    } catch (error) {

        ({ severity, detail, status, data = [] } = getResponse(error.response.data));

    } finally {
        spinner(false);
        functionCallback({
            severity: severity,
            detail: detail,
            status: status,
            data: data,
        });
    }
}

function getModulesMenu(module){

    let modules = {
        profile: {
            label: 'Pefil',
            icon: 'pi pi-user',
            route: 'profile.index',
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
    'error_email'     : 'El correo electrónico proporcionado, no corresponde a uno válido.',
    'error_phone'     : 'El número de celular proporcionado, no corresponde a uno válido.',
    'error_passwords' : 'Las contraseñas proporcionadas, no coinciden.',
    'form_empty'      : 'Se han encontrado campos vacíos en el formulario. Por favor, llenarlos.',
    'uuid_not_found'  : 'Ha ocurrido un problema al consultar la información solicitada.',
    'get_success'     : 'Se ha obtenido la información correctamente.',
    'update_success'  : 'Se ha realizado la actualización correctamente.',
    'register_success': 'Se ha realizado el registro correctamente.',
    'delete_success'  : 'Se ha realizado el borrado correctamente.',
    'get_error'       : 'Ha ocurrido un problema al obtener la información solicitada.',
    'update_error'    : 'Ha ocurrido un problema con la actualización.',
    'register_error'  : 'Ha ocurrido un problema con el registro.',
    'delete_error'    : 'Ha ocurrido un problema con el borrado.',
    'image_error'     : 'Ha ocurrido un problema con el regstro de la imagen.',
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

    let properties = {};
    Object.keys(object).forEach(element => {
        if (isEmpty(object[element])) {
            properties[element] = true;
        }
    });

    return {
        status: !Boolean(Object.keys(properties).length),
        alert: { severity: 'warn', detail: messages['form_empty']},
        properties: properties
    }
};

const validateSamePasword = (object) => {
    return {
        status: object.password == object.password_confirmation,
        alert: { severity: 'warn', detail: messages['error_passwords']},
    }
};

const validatePassword = (password) =>  {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return regex.test(password);
}







export {
    translate,
    fetchAPI,
    modalDimensions,
    validateEmail,
    isEmpty,
    getResponse,
    messages,
    getModulesMenu,
    validateFormIsEmpty,
    validateSamePasword,
    validatePassword,
    spinner
};
