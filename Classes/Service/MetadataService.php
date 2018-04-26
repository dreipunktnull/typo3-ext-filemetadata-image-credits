<?php

namespace DPN\FilemetadataImageCredits\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

class MetadataService
{
    /**
     * @var ConnectionPool
     */
    private $connectionPool;

    /**
     * @var QueryGenerator
     */
    private $queryGenerator;

    public function __construct(ConnectionPool $connectionPool, QueryGenerator $queryGenerator)
    {
        $this->connectionPool = $connectionPool;
        $this->queryGenerator = $queryGenerator;
    }

    public function findAllForRootPage($pageUid, $depth = 9999): array
    {
        $rootLinePIDs = $this->getRootLineForPage($pageUid);

        $rootPageUid = array_pop($rootLinePIDs);
        $childPids = $this->getChildPIDsWithRootpageUID($depth, $rootPageUid);

        $fileUIDs = $this->findFileUIDsInPages($childPids);
        if (true === empty($fileUIDs)) {
            return [];
        }

        return $this->findMetadata($fileUIDs);
    }

    public function findAllForSinglePage($pageUid): array
    {
        $fileUIDs = $this->findFileUIDsInPages([$pageUid]);
        if (true === empty($fileUIDs)) {
            return [];
        }

        return $this->findMetadata($fileUIDs);
    }

    /**
     * @param array $pageUIDs
     *
     * @return mixed
     */
    private function findFileUIDsInPages(array $pageUIDs = []): array
    {
        $qb = $this->connectionPool
            ->getConnectionForTable('sys_file')
            ->createQueryBuilder();

        $qb
            ->select('file.uid')
            ->from('sys_file', 'file')
            ->innerJoin('file', 'sys_file_metadata', 'meta', $qb->expr()->eq('file.uid', $qb->quoteIdentifier('meta.file')))
            ->innerJoin('file', 'sys_file_reference', 'references', $qb->expr()->eq('file.uid', $qb->quoteIdentifier('references.uid_local')))
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->isNotNull('meta.copyright'),
                    $qb->expr()->eq('file.type', 2),
                    $qb->expr()->eq('references.hidden', 0),
                    $qb->expr()->in('references.pid', $pageUIDs)
                )
            )
            ->groupBy('file.uid');

        return $qb->execute()->fetchAll();
    }

    public function findMetadata(array $fileUIDs = []): array
    {
        $uids = array_map(function ($item) {

            return $item['uid'];
        }, $fileUIDs);

        $qb = $this->connectionPool
            ->getConnectionForTable('sys_file_metadata')
            ->createQueryBuilder();

        $qb
            ->select('sys_file_metadata.*')
            ->from('sys_file_metadata')
            ->where(
                $qb->expr()->in('sys_file_metadata.uid', $uids)
            );

        return $qb->execute()->fetchAll();
    }

    private function getRootLineForPage(int $pageUid): array
    {
        $rootLineUtil = new RootlineUtility($pageUid);
        $rootLine = $rootLineUtil->get();

        $rootLinePIDs = array_map(function ($page) {
            return $page['uid'];
        }, $rootLine);

        return $rootLinePIDs;
    }

    /**
     * @param int $depth
     * @param int $rootPageUid
     * @return array
     */
    private function getChildPIDsWithRootpageUID($depth, $rootPageUid): array
    {
        $treeList = $this->queryGenerator->getTreeList($rootPageUid, $depth, 0, 1);

        $list = explode(',', $treeList);
        $list[] = $rootPageUid;

        return $list;
    }
}
