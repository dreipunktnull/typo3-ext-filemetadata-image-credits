<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'filemetadata_image_credits',
    'Configuration/TypoScript',
    '3.0 Filemetadata Image Credits'
);

if (TYPO3_MODE === 'BE') {
}
