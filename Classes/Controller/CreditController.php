<?php

namespace DPN\FilemetadataImageCredits\Controller;

use DPN\FilemetadataImageCredits\Service\MetadataService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CreditController extends ActionController
{
    /**
     * @var MetadataService
     */
    private $metadataService;

    public function __construct(MetadataService $metadataService)
    {
        parent::__construct();

        $this->metadataService = $metadataService;
    }

    public function siteAction()
    {
        $resourcesForSite = $this->metadataService->findAllForRootPage($GLOBALS['TSFE']->id);

        $this->view->assign('siteResources', $resourcesForSite);
    }

    public function currentPageAction()
    {
        $resourcesFromPage = $this->metadataService->findAllForSinglePage($GLOBALS['TSFE']->id);

        $this->view->assign('pageResources', $resourcesFromPage);
    }
}
