<?php

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'DPN.FilemetadataImageCredits',
    'Pi1',
    'Image Credits',
    'EXT:filemetadata_image_credits/ext_icon.gif'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['filemetadataimagecredits_pi1'] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['filemetadataimagecredits_pi1'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'filemetadataimagecredits_pi1',
    'FILE:EXT:filemetadata_image_credits/Configuration/FlexForms/flexform.xml'
);
