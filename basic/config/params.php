<?php

return [
    'adminEmail' => 'admin@example.com',
    //Ldap configuration
    'LDAPCFG' => [
        'domain_controllers' => ['edu.ds.fhnw.ch'/*,'adm.ds.fhnw.ch'*/], //only working on Testserver
        'base_dn' => 'ou=edu,ou=prod,dc=edu,dc=ds,dc=fhnw,dc=ch', // ou=edu,ou=prod,dc=edu,
        'admin_username' => 'u_18.39_lagerverwaltung02',
        'admin_password' => 'FHNW@2016',
        'follow_referrals' => true,
        'use_ssl' => false,
        'use_tls' => false,
        'use_sso' => false,
    ]
];
