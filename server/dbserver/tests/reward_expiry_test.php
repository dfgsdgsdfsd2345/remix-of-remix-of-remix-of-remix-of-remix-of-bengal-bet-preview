<?php
require __DIR__.'/../api/reward_expiry.php';
function checkExpiry($ok,$name){if(!$ok)throw new RuntimeException($name);echo "$name passed\n";}
$expiry=bbRewardExpiry('2026-11-23 18:00:00',30);
checkExpiry($expiry==='2026-12-23 18:00:00','Mystery thirty-day expiry');
$at=fn($s)=>(new DateTimeImmutable($s,new DateTimeZone('Asia/Dhaka')))->getTimestamp();
checkExpiry(bbRewardUnexpired($expiry,$at('2026-12-23 17:59:59')),'Before expiry accepted');
checkExpiry(!bbRewardUnexpired($expiry,$at('2026-12-23 18:00:00')),'Exact expiry denied');
checkExpiry(!bbRewardUnexpired($expiry,$at('2026-12-23 18:00:01')),'After expiry denied');
checkExpiry(!bbRewardUnexpired(null) && bbRewardExpiry('unknown',30)===null,'Unknown history fails closed');