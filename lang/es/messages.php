<?php

/*
|--------------------------------------------------------------------------
| Traducciones del formulario de contacto
|--------------------------------------------------------------------------
|
| La explicación de estas claves está en lang/en/messages.php.
|
*/

return [

    'form' => [
        'send' => 'Enviar',
        'success' => 'Gracias por tu mensaje. Te responderemos lo antes posible.',
        'choose' => 'Elige...',
        'honeypot' => 'Deja este campo vacío',
        'not_configured' => 'Aún no hay campos configurados. Configúralos en Contact Plugin.',
        'throttled' => 'Demasiados envíos. Inténtalo de nuevo más tarde.',
        'yes' => 'Sí',
        'no' => 'No',
    ],

    'mail' => [
        'subject' => 'Formulario de contacto',
        'heading' => 'Nuevo envío del formulario de contacto',
        'page' => 'Página',
    ],

    'types' => [
        'text' => 'Texto',
        'email' => 'Correo electrónico',
        'tel' => 'Teléfono',
        'url' => 'URL',
        'number' => 'Número',
        'date' => 'Fecha',
        'textarea' => 'Área de texto',
        'select' => 'Lista desplegable',
        'checkbox' => 'Casilla de verificación',
    ],

    'roles' => [
        'none' => 'Ninguno',
        'name' => 'Nombre del remitente',
        'email' => 'Correo del remitente',
        'subject' => 'Asunto',
    ],

    'defaults' => [
        'name' => 'Nombre',
        'email' => 'Correo electrónico',
        'subject' => 'Asunto',
        'message' => 'Mensaje',
    ],

    'block' => [
        'label' => 'Formulario de contacto',
        'description' => 'El formulario configurado en Contact Plugin. El titular se define aquí.',
        'eyebrow' => 'Antetítulo',
        'heading' => 'Titular',
        'heading_default' => 'Ponte en contacto',
        'lede' => 'Entradilla',
    ],

    'admin' => [
        'group' => 'Contact Plugin',
        'settings' => [
            'nav' => 'Formulario',
            'title' => 'Formulario de contacto',
            'saved' => 'Formulario de contacto guardado',
            'save' => 'Guardar',
            'restore' => 'Restaurar los campos predeterminados',
            'delivery' => 'Envío',
            'delivery_hint' => 'A dónde va un envío y qué ve el visitante después.',
            'recipient' => 'Destinatario',
            'recipient_hint' => 'Dejarlo vacío usa CONTACT_FORM_RECIPIENT del .env.',
            'subject_prefix' => 'Prefijo del asunto',
            'subject_prefix_hint' => 'Precede al asunto en el correo de notificación.',
            'button_label' => 'Texto del botón',
            'success_message' => 'Mensaje de agradecimiento',
            'privacy_note' => 'Texto de privacidad',
            'privacy_note_hint' => 'Texto opcional debajo del formulario.',
            'fields' => 'Campos',
            'fields_hint' => 'Los campos del formulario. El orden aquí es el orden en la página.',
            'add_field' => 'Añadir campo',
            'field_label' => 'Etiqueta',
            'field_key' => 'Clave',
            'field_key_hint' => 'Se guarda con el envío. No la cambies si ya hay envíos.',
            'field_type' => 'Tipo',
            'field_role' => 'Función',
            'field_role_hint' => 'Determina la dirección de respuesta y las columnas de la lista.',
            'field_choices' => 'Opciones',
            'field_choices_hint' => 'Una opción por línea.',
            'field_placeholder' => 'Marcador de posición',
            'field_width' => 'Ancho',
            'field_width_full' => 'Ancho completo',
            'field_width_half' => 'Medio ancho',
            'field_required' => 'Obligatorio',
        ],
        'submissions' => [
            'nav' => 'Envíos',
            'label' => 'Envío',
            'plural' => 'Envíos',
            'answers' => 'Respuestas',
            'answer_field' => 'Campo',
            'answer_value' => 'Respuesta',
            'page' => 'Página',
            'locale' => 'Idioma',
            'ip' => 'IP',
            'received' => 'Recibido',
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'subject' => 'Asunto',
        ],
    ],

];
