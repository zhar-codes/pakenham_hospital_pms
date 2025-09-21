<?php
// /includes/nav.php
// Uses $routeAdmin, $routeReception, $routeClinician, $routePatient (defined in header.php).
// Each item: key, label, href, top (show in top navbar), side (show in sidebar).

/* ========== ADMIN ========== */
$NAV_ADMIN = [
  ['key'=>'dashboard',    'label'=>'Dashboard',      'href'=>$routeAdmin.'/dashboard.php',      'top'=>true,  'side'=>true],
  ['key'=>'appointments', 'label'=>'Appointments',   'href'=>$routeAdmin.'/appointments.php',   'top'=>true,  'side'=>true],
  ['key'=>'patients',     'label'=>'Patients',       'href'=>$routeAdmin.'/patients.php',       'top'=>false, 'side'=>true],
  ['key'=>'arrivals',     'label'=>'Arrivals',       'href'=>$routeAdmin.'/arrivals_today.php', 'top'=>false, 'side'=>true],
  ['key'=>'helpdesk',     'label'=>'Helpdesk (FAQ)', 'href'=>$routeAdmin.'/helpdesk.php',       'top'=>false, 'side'=>true],
  ['key'=>'chat',         'label'=>'Chatbox',        'href'=>$routeAdmin.'/chat.php',           'top'=>false, 'side'=>true],
  ['key'=>'tickets',      'label'=>'Tickets',        'href'=>$routeAdmin.'/tickets.php',        'top'=>false, 'side'=>true],
  ['key'=>'audit',        'label'=>'Audit',          'href'=>$routeAdmin.'/audit.php',          'top'=>false, 'side'=>true],
  ['key'=>'reports',      'label'=>'Reports',        'href'=>$routeAdmin.'/reports.php',        'top'=>false, 'side'=>true],
  ['key'=>'profile',      'label'=>'Profile',        'href'=>$routeAdmin.'/profile.php',        'top'=>true,  'side'=>true],
  ['key'=>'settings',     'label'=>'Settings',       'href'=>$routeAdmin.'/settings.php',       'top'=>true,  'side'=>true],
];

/* ========== RECEPTION ========== */
$NAV_RECEPTION = [
  ['key'=>'dashboard',    'label'=>'Dashboard',     'href'=>$routeReception.'/dashboard.php',   'top'=>true,  'side'=>true],
  ['key'=>'checkin',      'label'=>'Check-in',      'href'=>$routeReception.'/checkin.php',     'top'=>true,  'side'=>true],
  ['key'=>'appointments', 'label'=>'Appointments',  'href'=>$routeReception.'/appointments.php', 'top'=>false, 'side'=>true],
  ['key'=>'patients',     'label'=>'Patients',      'href'=>$routeReception.'/patients.php',    'top'=>false, 'side'=>true],
  ['key'=>'tickets',      'label'=>'Tickets',       'href'=>$routeReception.'/tickets.php',     'top'=>false, 'side'=>true],
  ['key'=>'profile',      'label'=>'Profile',       'href'=>$routeReception.'/profile.php',     'top'=>true,  'side'=>true],
  ['key'=>'settings',     'label'=>'Settings',      'href'=>$routeReception.'/settings.php',    'top'=>true,  'side'=>true],
];

/* ========== CLINICIAN ========== */
$NAV_CLINICIAN = [
  ['key'=>'clin_dashboard', 'label'=>'Dashboard',       'href'=>$routeClinician.'/dashboard.php',      'top'=>true,  'side'=>true],
  ['key'=>'clin_schedule',  'label'=>'My Schedule',     'href'=>$routeClinician.'/schedule.php',       'top'=>true,  'side'=>true],
  ['key'=>'clin_patients',  'label'=>'Patients',        'href'=>$routeClinician.'/patients.php',       'top'=>false, 'side'=>true],
  ['key'=>'clin_arrivals',  'label'=>'Arrivals Today',  'href'=>$routeClinician.'/arrivals_today.php', 'top'=>false, 'side'=>true],
  ['key'=>'clin_profile',   'label'=>'Profile',         'href'=>$routeClinician.'/profile.php',        'top'=>true,  'side'=>true],
];

/* ========== PATIENT ========== */
$NAV_PATIENT = [
  ['key'=>'pat_dashboard',   'label'=>'Dashboard',        'href'=>$routePatient.'/dashboard.php',    'top'=>true,  'side'=>true],
  ['key'=>'pat_appts',       'label'=>'My Appointments',  'href'=>$routePatient.'/appointments.php', 'top'=>true,  'side'=>true],
  ['key'=>'pat_helpdesk',    'label'=>'Helpdesk',         'href'=>$routePatient.'/helpdesk.php',     'top'=>false, 'side'=>true],
  ['key'=>'pat_profile',     'label'=>'Profile / Settings','href'=>$routePatient.'/profile.php',     'top'=>true,  'side'=>true],
];
