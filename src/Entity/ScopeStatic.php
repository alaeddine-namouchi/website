<?php

namespace App\Entity;

class ScopeStatic
{

    public const NEWS = "Gestion des actualités";
    public const HISTORY_TRAVEL = 'Historique Transport collectif';
    public const HISTORY_IDENTITY = 'Historique Identités visuelles';
    public const COM_PRESS = 'Communiqué de presse';
    public const DOC_PRESS = 'Dossier de presse';
    public const ACTIVITY_RAPPORT = 'Rapport d\'activité';
    public const CLIENT = 'Ecoute Clientèle';
    public const CONTACT = 'Contact';
    public const RECLAMATION = 'Réclamation';
    public const ABOUT = 'A propos l\'entreprise';
    public const INFO_ACCESS = 'Accès à l\'information';
    public const TRAVEL_CARD = 'Transport à la carte';
    public const SCHEDULE = 'Marche Horaires';
    public const ALL = [
        self::NEWS,
        self::HISTORY_IDENTITY,
        self::HISTORY_TRAVEL,
        self::CLIENT,
        self::CONTACT,
        self::COM_PRESS,
        self::TRAVEL_CARD,
        self::DOC_PRESS,
        self::ABOUT,
        self::ACTIVITY_RAPPORT,
        self::RECLAMATION,
        self::INFO_ACCESS,
        self::SCHEDULE,
    ];
    public const COMMUNICATION = [
        self::NEWS,
        self::HISTORY_IDENTITY,
        self::HISTORY_TRAVEL,
        self::COM_PRESS,
        ];

}
