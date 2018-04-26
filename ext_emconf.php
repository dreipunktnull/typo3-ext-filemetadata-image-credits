<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '3.0 File Metadata Credits',
    'description' => 'Give Credits for your images',
    'category' => 'frontend',
    'author' => 'Cedric Ziel',
    'author_email' => 'ziel@dreipunktnull.com',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => true,
    'createDirs' => '',
    'dividers2tabs' => true,
    'clearCacheOnLoad' => 0,
    'version' => '0.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.8-9.2.99',
            'filemetadata' => '7.6.8-9.2.99',
            'fluid_styled_content' => '7.6.8-9.2.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => [
            "DPN\\FilemetadataImageCredits\\" => 'Classes',
        ],
    ],
];
