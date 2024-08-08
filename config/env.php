<?php

return  [
    /**Establece como se guadará los archivos ya sea local storage (default) o en la nube con lagun otro servicio
     * por ejemplo: 'default', 'google-cloud', 'amazon-s3'
     */
    'storage_config' => env('STORAGE_CONFIG', 'default'),
];

