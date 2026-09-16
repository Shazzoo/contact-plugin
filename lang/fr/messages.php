<?php

/*
|--------------------------------------------------------------------------
| Traductions du formulaire de contact
|--------------------------------------------------------------------------
|
| L'explication de ces clés se trouve dans lang/en/messages.php.
|
*/

return [

    'form' => [
        'send' => 'Envoyer',
        'success' => 'Merci pour votre message. Nous vous répondrons dès que possible.',
        'choose' => 'Choisissez...',
        'honeypot' => 'Laissez ce champ vide',
        'not_configured' => "Ce bloc n'a pas encore de formulaire. Créez-en un sous Plugins et choisissez-le ici.",
        'throttled' => 'Trop d\'envois. Veuillez réessayer plus tard.',
        'yes' => 'Oui',
        'no' => 'Non',
    ],

    'mail' => [
        'subject' => 'Formulaire de contact',
        'heading' => 'Nouvel envoi via le formulaire de contact',
        'page' => 'Page',
    ],

    'types' => [
        'text' => 'Texte',
        'email' => 'E-mail',
        'tel' => 'Téléphone',
        'url' => 'URL',
        'number' => 'Nombre',
        'date' => 'Date',
        'textarea' => 'Zone de texte',
        'select' => 'Liste déroulante',
        'checkbox' => 'Case à cocher',
    ],

    'roles' => [
        'none' => 'Aucun',
        'name' => "Nom de l'expéditeur",
        'email' => "E-mail de l'expéditeur",
        'subject' => 'Objet',
    ],

    'defaults' => [
        'name' => 'Nom',
        'email' => 'E-mail',
        'subject' => 'Objet',
        'message' => 'Message',
    ],

    'block' => [
        'label' => 'Formulaire de contact',
        'form' => 'Formulaire',
        'form_hint' => 'Lequel des formulaires configurés sous Plugins ce bloc affiche.',
        'description' => "L'un des formulaires configurés sous Plugins. Choisissez lequel, et réglez ici le texte autour.",
        'eyebrow' => 'Surtitre',
        'heading' => 'Titre',
        'heading_default' => 'Contactez-nous',
        'lede' => 'Chapeau',
    ],

    'admin' => [
        'group' => 'Contact Plugin',
        'plugins_group' => 'Plugins',
        'forms' => [
            'nav' => 'Formulaires',
            'label' => 'Formulaire',
            'plural' => 'Formulaires',
            'identity' => 'Le formulaire',
            'identity_hint' => 'À quoi vous reconnaissez ce formulaire, et ce vers quoi pointe un bloc.',
            'name' => 'Nom',
            'key' => 'Clé',
            'key_hint' => 'Enregistrée dans le bloc placé. Ne la modifiez plus une fois le formulaire présent sur une page.',
        ],
        'settings' => [
            'restore' => 'Rétablir les champs par défaut',
            'delivery' => 'Envoi',
            'delivery_hint' => 'Où va un envoi et ce que le visiteur voit ensuite.',
            'recipient' => 'Destinataire',
            'recipient_hint' => 'Laisser vide utilise CONTACT_FORM_RECIPIENT du .env.',
            'subject_prefix' => "Préfixe de l'objet",
            'subject_prefix_hint' => "Précède l'objet dans l'e-mail de notification.",
            'button_label' => 'Libellé du bouton',
            'success_message' => 'Message de remerciement',
            'privacy_note' => 'Mention de confidentialité',
            'privacy_note_hint' => 'Texte facultatif sous le formulaire.',
            'fields' => 'Champs',
            'fields_hint' => "Les champs du formulaire. L'ordre ici est l'ordre sur la page.",
            'add_field' => 'Ajouter un champ',
            'field_label' => 'Libellé',
            'field_key' => 'Clé',
            'field_key_hint' => "Enregistrée avec l'envoi. Ne la modifiez plus s'il existe déjà des envois.",
            'field_type' => 'Type',
            'field_role' => 'Rôle',
            'field_role_hint' => "Détermine l'adresse de réponse et les colonnes de la liste.",
            'field_choices' => 'Choix',
            'field_choices_hint' => 'Un choix par ligne.',
            'field_placeholder' => 'Texte indicatif',
            'field_width' => 'Largeur',
            'field_width_full' => 'Pleine largeur',
            'field_width_half' => 'Demi-largeur',
            'field_required' => 'Obligatoire',
        ],
        'submissions' => [
            'nav' => 'Envois',
            'form' => 'Formulaire',
            'label' => 'Envoi',
            'plural' => 'Envois',
            'answers' => 'Réponses',
            'answer_field' => 'Champ',
            'answer_value' => 'Réponse',
            'page' => 'Page',
            'locale' => 'Langue',
            'ip' => 'IP',
            'received' => 'Reçu',
            'name' => 'Nom',
            'email' => 'E-mail',
            'subject' => 'Objet',
        ],
    ],

];
