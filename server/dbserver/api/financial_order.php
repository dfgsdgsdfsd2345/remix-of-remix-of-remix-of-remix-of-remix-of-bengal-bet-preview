<?php
/** SQL predicates for ordered settlements with conservative unknown-history fallback. */
function bbFinancialAfter(?int $seq, string $since, string $column, bool $credit): array {
    $op=$credit?'>=':'>';
    if($seq!==null)return ["(financial_seq > ? OR (financial_seq IS NULL AND $column $op ?))",[$seq,$since]];
    return ["(financial_seq IS NOT NULL OR $column $op ?)",[$since]];
}
function bbFinancialBoundary(string $uid, string $kind): array {
    if($kind==='rebate'){
        $row=Database::fetchOne("SELECT financial_seq,created_at FROM transactions WHERE user_id=? AND type='bonus' AND status='success' AND description LIKE 'রিয়েল টাইম রিবেট%' ORDER BY (financial_seq IS NOT NULL) DESC,financial_seq DESC,created_at DESC LIMIT 1",[$uid]);
    }else{
        $row=Database::fetchOne("SELECT financial_seq,created_at FROM transactions WHERE user_id=? AND type='withdraw' AND status IN ('pending','success') ORDER BY (financial_seq IS NOT NULL) DESC,financial_seq DESC,created_at DESC LIMIT 1",[$uid]);
    }
    return ['seq'=>isset($row['financial_seq'])?(int)$row['financial_seq']:null,'since'=>$row['created_at']??'1970-01-01 00:00:00','hasBoundary'=>(bool)$row];
}