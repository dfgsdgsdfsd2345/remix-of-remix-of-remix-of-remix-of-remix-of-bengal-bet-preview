<?php
/** Strict Bangladesh-time expiry; unknown issue times are not claimable. */
function bbRewardExpiry(?string $issuedAt, int $days): ?string {
    if (!$issuedAt || $days<1) return null;
    $date=DateTimeImmutable::createFromFormat('!Y-m-d H:i:s',$issuedAt,new DateTimeZone('Asia/Dhaka'));
    if (!$date || $date->format('Y-m-d H:i:s')!==$issuedAt) return null;
    return $date->modify('+'.$days.' days')->format('Y-m-d H:i:s');
}
function bbRewardUnexpired(?string $expiresAt, ?int $now=null): bool {
    if (!$expiresAt) return false;
    $date=DateTimeImmutable::createFromFormat('!Y-m-d H:i:s',$expiresAt,new DateTimeZone('Asia/Dhaka'));
    return $date && $date->format('Y-m-d H:i:s')===$expiresAt && ($now??time())<$date->getTimestamp();
}