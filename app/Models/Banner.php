<?php

namespace App\Models;

use App\DTO\Visitor;
use App\Infrastructure\Database;
use Throwable;

class Banner
{
    public function __construct(private Database $database)
    {
        //
    }

    /**
     * @throws Throwable
     */
    public function trackVisit(Visitor $visitor): void
    {
        $this->database->startTransaction();

        try {
            ($bannerVisitId = $this->fetchExistingVisit($visitor))
                ? $this->updateVisitCounter($bannerVisitId)
                : $this->insertVisit($visitor);
        } catch (Throwable $exception) {
            $this->database->rollback();
            throw $exception;
        }

        $this->database->commit();
    }

    private function fetchExistingVisit(Visitor $visitor): int|false
    {
        $sql = <<<SQL
            SELECT id 
            FROM visitors 
            WHERE 
                ip_address = :ip_address 
                AND user_agent = :user_agent 
                AND page_url = :page_url 
            FOR UPDATE
        SQL;

        $stmt = $this->database->prepare($sql);

        $stmt->execute([
            'ip_address' => $visitor->getIpAddress(),
            'user_agent' => $visitor->getUserAgent(),
            'page_url' => $visitor->getPageUrl()
        ]);

        $id = $stmt->fetchColumn();

        return (false === $id) ? false : (int)$id;
    }

    private function insertVisit(Visitor $visitor): void
    {
        $sql = <<<SQL
            INSERT INTO visitors SET
                ip_address = :ip_address,
                user_agent = :user_agent,
                page_url = :page_url,
                view_date = now(),
                views_count = 1
        SQL;

        $statement = $this->database->prepare($sql);

        $statement->execute([
            'ip_address' => $visitor->getIpAddress(),
            'user_agent' => $visitor->getUserAgent(),
            'page_url' => $visitor->getPageUrl()
        ]);
    }

    private function updateVisitCounter(int $id): void
    {
        $sql = <<<SQL
            UPDATE visitors SET 
                views_count = views_count + 1, 
                view_date = now() 
            WHERE id = :id
        SQL;

        $statement = $this->database->prepare($sql);

        $statement->execute(['id' => $id]);
    }
}
