<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DPN.FilemetadataImageCredits',
    'Pi1',
    [
        'Credit' => 'site,currentPage',
    ],
    [
        'Credit' => '',
    ]
);
