<?php
/** Admin-editable promotion rules. Keep identical to src/bengalbet/services/promoRules.ts. */
if (!function_exists('bbPromoRulesDefaults')) {
function bbSlotDailyTierDefaults(): array {
    $o = []; foreach ([[1000,3],[3000,8],[5000,12],[10000,15],[20000,18],[30000,21],[40000,25],[50000,28],[60000,31],[70000,35],[80000,38],[90000,41],[100000,45],[200000,100],[300000,200],[400000,300],[500000,400],[600000,500],[700000,600],[800000,700],[900000,800],[1000000,900],[2000000,2777],[3000000,3777],[5000000,7777],[10000000,17777]] as [$b,$v]) $o[] = ['bet' => $b, 'bonus' => $v];
    return $o;
}
function bbPromoRulesDefaults(): array {
    return [
        'loginHammerPerDay' => 1,
        'depositEggsPerDay' => 3,
        'wheelTicketMinDeposit' => 300,
        'wheelTicketsPerDay' => 1,
        'redPacket' => ['enabled' => true, 'hours' => [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22], 'durationMinutes' => 30, 'perRoundLimit' => 50],
        'rescue' => ['enabled' => true, 'claimDeadlineHour' => 10, 'claimFromHour' => 22, 'claimWindowHours' => 24, 'categories' => ['slot', 'fishing']],
        'vip' => ['weeklyClaimDay' => 1, 'monthlyClaimDay' => 1, 'monthlyHour' => 15],
        'appBonus' => ['enabled' => true, 'amount' => 52],
        'slotDaily' => ['enabled' => true, 'minBet' => 1000, 'ratePercent' => 0, 'maxBonus' => 17777, 'claimFromHour' => 9, 'tiers' => bbSlotDailyTierDefaults()],
        'rebate' => ['enabled' => true, 'ratePercent' => 3, 'tiers' => [['bet' => 1, 'ratePercent' => 0.3], ['bet' => 1000000, 'ratePercent' => 0.6], ['bet' => 10000000, 'ratePercent' => 1.5], ['bet' => 50000000, 'ratePercent' => 3]]],
        'memberDay' => ['enabled' => true, 'day' => 13, 'claimFromHour' => 12, 'minBet' => 1000, 'ratePercent' => 1, 'maxBonus' => 100000],
        'withdrawal' => ['enabled' => true, 'depositTurnover' => 1, 'depositBonusTurnover' => 19, 'otherBonusTurnover' => 1],
        'missions' => ['enabled' => true, 'category' => 'slot', 'tiers' => [['bet' => 1000, 'bonus' => 3], ['bet' => 3000, 'bonus' => 8], ['bet' => 5000, 'bonus' => 12], ['bet' => 10000, 'bonus' => 18], ['bet' => 20000, 'bonus' => 56], ['bet' => 50000, 'bonus' => 128], ['bet' => 100000, 'bonus' => 268], ['bet' => 200000, 'bonus' => 588], ['bet' => 500000, 'bonus' => 1288], ['bet' => 1000000, 'bonus' => 2888], ['bet' => 2000000, 'bonus' => 5888], ['bet' => 5000000, 'bonus' => 12888], ['bet' => 10000000, 'bonus' => 17777], ['bet' => 15000000, 'bonus' => 22888], ['bet' => 20000000, 'bonus' => 28888], ['bet' => 25000000, 'bonus' => 35888], ['bet' => 30000000, 'bonus' => 42888], ['bet' => 40000000, 'bonus' => 55888], ['bet' => 50000000, 'bonus' => 68888], ['bet' => 60000000, 'bonus' => 82888], ['bet' => 70000000, 'bonus' => 98888], ['bet' => 80000000, 'bonus' => 118888], ['bet' => 90000000, 'bonus' => 138888], ['bet' => 100000000, 'bonus' => 168888], ['bet' => 150000000, 'bonus' => 218888], ['bet' => 200000000, 'bonus' => 300000]]],
        'referralLevels' => ['enabled' => true, 'tiers' => [['friends' => 10, 'bonus' => 1500], ['friends' => 15, 'bonus' => 1500], ['friends' => 20, 'bonus' => 1500], ['friends' => 30, 'bonus' => 3000], ['friends' => 40, 'bonus' => 3000], ['friends' => 50, 'bonus' => 3000], ['friends' => 60, 'bonus' => 3000], ['friends' => 70, 'bonus' => 3000], ['friends' => 80, 'bonus' => 3000], ['friends' => 90, 'bonus' => 3000], ['friends' => 100, 'bonus' => 10000], ['friends' => 150, 'bonus' => 15000], ['friends' => 200, 'bonus' => 15000], ['friends' => 250, 'bonus' => 15000], ['friends' => 300, 'bonus' => 15000], ['friends' => 350, 'bonus' => 15000], ['friends' => 400, 'bonus' => 15000], ['friends' => 500, 'bonus' => 15000], ['friends' => 600, 'bonus' => 30000], ['friends' => 700, 'bonus' => 30000], ['friends' => 800, 'bonus' => 30000], ['friends' => 1000, 'bonus' => 60000], ['friends' => 1500, 'bonus' => 150000], ['friends' => 2000, 'bonus' => 150000], ['friends' => 2500, 'bonus' => 150000], ['friends' => 3000, 'bonus' => 150000], ['friends' => 4000, 'bonus' => 300000], ['friends' => 5000, 'bonus' => 300000], ['friends' => 6000, 'bonus' => 300000], ['friends' => 7000, 'bonus' => 300000], ['friends' => 8000, 'bonus' => 300000], ['friends' => 9000, 'bonus' => 300000], ['friends' => 10000, 'bonus' => 300000], ['friends' => 11000, 'bonus' => 300000], ['friends' => 12000, 'bonus' => 300000], ['friends' => 13000, 'bonus' => 300000], ['friends' => 14000, 'bonus' => 300000], ['friends' => 15000, 'bonus' => 300000], ['friends' => 20000, 'bonus' => 1500000], ['friends' => 25000, 'bonus' => 1500000], ['friends' => 30000, 'bonus' => 1500000], ['friends' => 35000, 'bonus' => 1500000], ['friends' => 40000, 'bonus' => 1500000], ['friends' => 50000, 'bonus' => 3000000], ['friends' => 60000, 'bonus' => 3000000], ['friends' => 70000, 'bonus' => 3000000], ['friends' => 80000, 'bonus' => 3000000], ['friends' => 90000, 'bonus' => 3000000], ['friends' => 100000, 'bonus' => 3000000]]],
    ];
}
function bbPromoNum($v, float $min, float $max, string $name): float {
    if (!is_int($v) && !is_float($v) && !is_numeric($v)) throw new InvalidArgumentException("Invalid $name");
    $v = (float)$v; if (!is_finite($v) || $v < $min || $v > $max) throw new InvalidArgumentException("Invalid $name"); return round($v, 2);
}
function bbPromoInt($v, int $min, int $max, string $name): int {
    if (!is_int($v) && !(is_numeric($v) && (string)(int)$v === (string)$v)) throw new InvalidArgumentException("Invalid $name");
    $v = (int)$v; if ($v < $min || $v > $max) throw new InvalidArgumentException("Invalid $name"); return $v;
}
function bbPromoBool($v, string $name): bool { if (!is_bool($v)) throw new InvalidArgumentException("Invalid $name"); return $v; }
function bbPromoTiers($t, string $countKey, string $name, int $maxCount): array {
    if (!is_array($t) || count($t) < 1 || count($t) > 60) throw new InvalidArgumentException("Invalid $name");
    $out = []; $prev = -1;
    foreach (array_values($t) as $x) {
        if (!is_array($x)) throw new InvalidArgumentException("Invalid $name");
        $n = bbPromoNum($x[$countKey] ?? null, 1, $maxCount, "$name.$countKey");
        if ($n <= $prev) throw new InvalidArgumentException("$name must be in ascending order");
        $out[] = [$countKey => $n, 'bonus' => bbPromoNum($x['bonus'] ?? null, 0, 10000000, "$name.bonus")]; $prev = $n;
    }
    return $out;
}
function bbRebateTiers($t): array {
    if (!is_array($t) || count($t) > 40) throw new InvalidArgumentException('Invalid rebate.tiers');
    $out = []; $prev = -1;
    foreach (array_values($t) as $x) {
        if (!is_array($x)) throw new InvalidArgumentException('Invalid rebate.tiers');
        $b = bbPromoNum($x['bet'] ?? null, 1, 100000000000, 'rebate.tiers.bet');
        if ($b <= $prev) throw new InvalidArgumentException('rebate.tiers must be in ascending order');
        $out[] = ['bet' => $b, 'ratePercent' => bbPromoNum($x['ratePercent'] ?? null, 0, 3, 'rebate.tiers.ratePercent')]; $prev = $b;
    }
    return $out;
}
function bbSlotDailyBonus(array $c, float $t): float {
    if (empty($c['tiers'])) return bbTurnoverBonus($t, (float)$c['minBet'], (float)$c['ratePercent'], (float)$c['maxBonus']);
    if ($t < (float)$c['minBet']) return 0.0;
    $sum = 0.0; foreach ($c['tiers'] as $x) if ($t >= (float)$x['bet']) $sum += (float)$x['bonus'];
    return round((float)$c['maxBonus'] > 0 ? min($sum, (float)$c['maxBonus']) : $sum, 2);
}
function bbRebateRate(array $c, float $lifetime): float {
    if (empty($c['tiers'])) return (float)$c['ratePercent'];
    $r = 0.0; foreach ($c['tiers'] as $x) if ($lifetime >= (float)$x['bet']) $r = (float)$x['ratePercent'];
    return $r;
}
function bbValidatePromoRules($c): array {
    if (!is_array($c)) throw new InvalidArgumentException('Invalid promotion rules');
    $d = bbPromoRulesDefaults();
    if (!isset($c['missions'])) $c['missions'] = $d['missions'];
    if (!isset($c['referralLevels'])) $c['referralLevels'] = $d['referralLevels'];
    foreach (['redPacket', 'rescue', 'vip', 'appBonus', 'slotDaily', 'rebate', 'memberDay', 'withdrawal'] as $k) if (!isset($c[$k]) || !is_array($c[$k])) throw new InvalidArgumentException("Invalid $k");
    $hours = $c['redPacket']['hours'] ?? null;
    if (!is_array($hours) || count($hours) < 1 || count($hours) > 24) throw new InvalidArgumentException('Invalid redPacket.hours');
    $h = []; foreach ($hours as $x) $h[] = bbPromoInt($x, 0, 23, 'redPacket.hours');
    $h = array_values(array_unique($h)); sort($h);
    $cats = $c['rescue']['categories'] ?? null;
    $allowed = ['slot', 'fishing', 'live', 'crash', 'table', 'arcade', 'poker', 'sports', 'esports', 'lottery'];
    if (!is_array($cats) || !count($cats)) throw new InvalidArgumentException('Invalid rescue.categories');
    $cs = []; foreach ($cats as $x) { if (!in_array($x, $allowed, true)) throw new InvalidArgumentException('Invalid rescue.categories'); $cs[] = $x; }
    $cs = array_values(array_unique($cs));
    $amount = $c['appBonus']['amount'] ?? null;
    if (!is_numeric($amount) || $amount < 0 || $amount > 100000) throw new InvalidArgumentException('Invalid appBonus.amount');
    return [
        'loginHammerPerDay' => bbPromoInt($c['loginHammerPerDay'] ?? null, 0, 10, 'loginHammerPerDay'),
        'depositEggsPerDay' => bbPromoInt($c['depositEggsPerDay'] ?? null, 0, 20, 'depositEggsPerDay'),
        'wheelTicketMinDeposit' => bbPromoInt($c['wheelTicketMinDeposit'] ?? null, 0, 10000000, 'wheelTicketMinDeposit'),
        'wheelTicketsPerDay' => bbPromoInt($c['wheelTicketsPerDay'] ?? null, 0, 10, 'wheelTicketsPerDay'),
        'redPacket' => [
            'enabled' => bbPromoBool($c['redPacket']['enabled'] ?? null, 'redPacket.enabled'),
            'hours' => $h,
            'durationMinutes' => bbPromoInt($c['redPacket']['durationMinutes'] ?? null, 1, 59, 'redPacket.durationMinutes'),
            'perRoundLimit' => bbPromoInt($c['redPacket']['perRoundLimit'] ?? null, 1, 100000, 'redPacket.perRoundLimit'),
        ],
        'rescue' => [
            'enabled' => bbPromoBool($c['rescue']['enabled'] ?? null, 'rescue.enabled'),
            'claimDeadlineHour' => bbPromoInt($c['rescue']['claimDeadlineHour'] ?? null, 1, 24, 'rescue.claimDeadlineHour'),
            ...(isset($c['rescue']['claimFromHour']) ? ['claimFromHour'=>bbPromoInt($c['rescue']['claimFromHour'],0,23,'rescue.claimFromHour'), 'claimWindowHours'=>bbPromoInt($c['rescue']['claimWindowHours']??24,1,24,'rescue.claimWindowHours')] : []),
            'categories' => $cs,
        ],
        'vip' => [
            'weeklyClaimDay' => bbPromoInt($c['vip']['weeklyClaimDay'] ?? null, 1, 7, 'vip.weeklyClaimDay'),
            'monthlyClaimDay' => bbPromoInt($c['vip']['monthlyClaimDay'] ?? null, 1, 28, 'vip.monthlyClaimDay'),
            'monthlyHour' => bbPromoInt($c['vip']['monthlyHour'] ?? 15, 0, 23, 'vip.monthlyHour'),
        ],
        'appBonus' => ['enabled' => bbPromoBool($c['appBonus']['enabled'] ?? null, 'appBonus.enabled'), 'amount' => round((float)$amount, 2)],
        'slotDaily' => [
            'enabled' => bbPromoBool($c['slotDaily']['enabled'] ?? null, 'slotDaily.enabled'),
            'minBet' => bbPromoNum($c['slotDaily']['minBet'] ?? null, 0, 100000000, 'slotDaily.minBet'),
            'ratePercent' => bbPromoNum($c['slotDaily']['ratePercent'] ?? null, 0, 100, 'slotDaily.ratePercent'),
            'maxBonus' => bbPromoNum($c['slotDaily']['maxBonus'] ?? null, 0, 100000000, 'slotDaily.maxBonus'),
            'claimFromHour' => bbPromoInt($c['slotDaily']['claimFromHour'] ?? null, 0, 23, 'slotDaily.claimFromHour'),
            'tiers' => !array_key_exists('tiers', $c['slotDaily']) ? $d['slotDaily']['tiers'] : (is_array($c['slotDaily']['tiers']) && !count($c['slotDaily']['tiers']) ? [] : bbPromoTiers($c['slotDaily']['tiers'], 'bet', 'slotDaily.tiers', 10000000000)),
        ],
        'rebate' => [
            'enabled' => bbPromoBool($c['rebate']['enabled'] ?? null, 'rebate.enabled'),
            'ratePercent' => bbPromoNum($c['rebate']['ratePercent'] ?? null, 0, 3, 'rebate.ratePercent'),
            'tiers' => bbRebateTiers(array_key_exists('tiers', $c['rebate']) ? $c['rebate']['tiers'] : $d['rebate']['tiers']),
        ],
        'memberDay' => [
            'enabled' => bbPromoBool($c['memberDay']['enabled'] ?? null, 'memberDay.enabled'),
            'day' => bbPromoInt($c['memberDay']['day'] ?? null, 2, 28, 'memberDay.day'),
            'claimFromHour' => bbPromoInt($c['memberDay']['claimFromHour'] ?? 12,0,23,'memberDay.claimFromHour'),
            'minBet' => bbPromoNum($c['memberDay']['minBet'] ?? null, 0, 100000000, 'memberDay.minBet'),
            'ratePercent' => bbPromoNum($c['memberDay']['ratePercent'] ?? null, 0, 100, 'memberDay.ratePercent'),
            'maxBonus' => bbPromoNum($c['memberDay']['maxBonus'] ?? null, 0, 100000000, 'memberDay.maxBonus'),
        ],
        'withdrawal' => [
            'enabled' => bbPromoBool($c['withdrawal']['enabled'] ?? null, 'withdrawal.enabled'),
            'depositTurnover' => bbPromoNum($c['withdrawal']['depositTurnover'] ?? null, 0, 50, 'withdrawal.depositTurnover'),
            'depositBonusTurnover' => bbPromoNum($c['withdrawal']['depositBonusTurnover'] ?? null, 0, 50, 'withdrawal.depositBonusTurnover'),
            'otherBonusTurnover' => bbPromoNum($c['withdrawal']['depositTurnover'] ?? null, 0, 50, 'withdrawal.depositTurnover'),
        ],
        'missions' => [
            'enabled' => bbPromoBool($c['missions']['enabled'] ?? null, 'missions.enabled'),
            'category' => in_array($c['missions']['category'] ?? '', array_merge(['all'], $allowed), true) ? $c['missions']['category'] : throw new InvalidArgumentException('Invalid missions.category'),
            'tiers' => bbPromoTiers($c['missions']['tiers'] ?? null, 'bet', 'missions.tiers', 10000000000),
        ],
        'referralLevels' => [
            'enabled' => bbPromoBool($c['referralLevels']['enabled'] ?? null, 'referralLevels.enabled'),
            'tiers' => bbPromoTiers($c['referralLevels']['tiers'] ?? null, 'friends', 'referralLevels.tiers', 100000),
        ],
    ];
}
function bbMemberDayOpen(array $c, int $timestamp): bool {
    $now=(new DateTimeImmutable('@'.$timestamp))->setTimezone(new DateTimeZone('Asia/Dhaka'));
    return !empty($c['enabled']) && (int)$now->format('j')===(int)$c['day'] && (int)$now->format('G')>=(int)($c['claimFromHour']??12);
}
/** Last opened daily window; loss is from the completed day before its opening date. */
function bbRescueWindow(array $c, int $timestamp): array {
    $now=(new DateTimeImmutable('@'.$timestamp))->setTimezone(new DateTimeZone('Asia/Dhaka'));
    if (!isset($c['claimFromHour'])) {
        $end=$now->setTime(0,0)->modify('+'.(int)$c['claimDeadlineHour'].' hours');
        return ['date'=>$now->modify('-1 day')->format('Y-m-d'),'opensAt'=>$now->setTime(0,0)->format('Y-m-d H:i:s'),'expiresAt'=>$end->format('Y-m-d H:i:s'),'open'=>!empty($c['enabled']) && $now<$end];
    }
    $start=$now->setTime((int)$c['claimFromHour'],0);
    if ($now<$start) $start=$start->modify('-1 day');
    $end=$start->modify('+'.(int)($c['claimWindowHours']??24).' hours');
    return ['date'=>$start->modify('-1 day')->format('Y-m-d'),'opensAt'=>$start->format('Y-m-d H:i:s'),'expiresAt'=>$end->format('Y-m-d H:i:s'),'open'=>!empty($c['enabled']) && $now>=$start && $now<$end];
}
function bbPromoRules(): array {
    static $cache = null; if ($cache !== null) return $cache;
    $row = Database::fetchOne('SELECT config_json FROM promo_rules_config WHERE id = 1');
    if (!$row) return $cache = bbPromoRulesDefaults();
    try { return $cache = bbValidatePromoRules(json_decode($row['config_json'], true)); }
    catch (InvalidArgumentException $e) { return $cache = bbPromoRulesDefaults(); }
}
}
