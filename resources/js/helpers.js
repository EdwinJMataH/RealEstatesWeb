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


export {
    modalDimensions
};
