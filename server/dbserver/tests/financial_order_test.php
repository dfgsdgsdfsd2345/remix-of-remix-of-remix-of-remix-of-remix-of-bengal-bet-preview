<?php
require __DIR__.'/../api/financial_order.php';
function checkOrder($condition,$message){if(!$condition)throw new RuntimeException($message);}
[$sql,$args]=bbFinancialAfter(8,'2026-11-03 12:00:00','created_at',true);
checkOrder($args===[8,'2026-11-03 12:00:00'],'Shared sequence is authoritative');
checkOrder(str_contains($sql,'financial_seq > ?'),'Only events after withdrawal count');
checkOrder(str_contains($sql,'financial_seq IS NULL AND created_at >= ?'),'Unknown credits fail closed');
[$sql,$args]=bbFinancialAfter(8,'2026-11-03 12:00:00','`time`',false);
checkOrder(str_contains($sql,'`time` > ?'),'Unknown same-second bets cannot satisfy wagering');
[$sql,$args]=bbFinancialAfter(null,'2026-11-03 12:00:00','`time`',false);
checkOrder(str_contains($sql,'financial_seq IS NOT NULL OR'),'New ordered bets follow a historical boundary');
echo "Financial history predicates passed\n";