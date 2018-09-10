<?php
namespace Centreon\Domain\Repository;

use Centreon\Infrastructure\CentreonLegacyDB\ServiceEntityRepository;
use PDO;

class TimePeriodExcludeRelationRepository extends ServiceEntityRepository
{

    /**
     * Export
     * 
     * @param array $timeperiodList
     * @return array
     */
    public function export(array $timeperiodList = null): array
    {
        if (!$timeperiodList) {
            return [];
        }

        $list = join(',', $timeperiodList);

        $sql = <<<SQL
SELECT
    t.*
FROM timeperiod_exclude_relations AS t
WHERE t.timeperiod_id IN ({$list})
GROUP BY t.exclude_id
SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = [];

        while ($row = $stmt->fetch()) {
            $result[] = $row;
        }

        return $result;
    }
}
