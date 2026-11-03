<?php
/**
 * Bonus/deposit wagering requirement before withdrawal (admin promo rules -> withdrawal).
 * Counts approved deposits, their bonus and other credited bonuses (including referral commissions) since the member's last
 * non-rejected withdrawal, and the valid bets placed in that same period.
 */
require_once __DIR__ . '/promo_rules.php';
require_once __DIR__ . '/turnover_math.php';
require_once __DIR__ . '/financial_order.php';
if (!function_exists('bbTurnoverStatus')) {
function bbTurnoverStatus(string $uid): array {
    $w = bbPromoRules()['withdrawal'];
    $boundary=bbFinancialBoundary($uid,'withdraw');$since=$boundary['since'];
    [$creditWhere,$creditArgs]=bbFinancialAfter($boundary['seq'],$since,'COALESCE(processed_at,created_at)',true);
    [$bonusWhere,$bonusArgs]=bbFinancialAfter($boundary['seq'],$since,'created_at',true);
    [$betWhere,$betArgs]=bbFinancialAfter($boundary['seq'],$since,'`time`',false);
    $dep=Database::fetchOne("SELECT COALESCE(SUM(amount),0) a,COALESCE(SUM(bonus),0) b FROM transactions WHERE user_id=? AND type='deposit' AND status='success' AND $creditWhere",array_merge([$uid],$creditArgs));
    $other=(float)Database::fetchOne("SELECT COALESCE(SUM(amount),0) a FROM transactions WHERE user_id=? AND type='bonus' AND status='success' AND $bonusWhere",array_merge([$uid],$bonusArgs))['a'];
    $bets=(float)Database::fetchOne("SELECT COALESCE(SUM(valid_bet),0) t FROM bets WHERE user_id=? AND $betWhere",array_merge([$uid],$betArgs))['t'];
    // Unknown historical deposits precede new ones; historical ties remain conservative.
    $first=Database::fetchOne("SELECT bonus,financial_seq,COALESCE(processed_at,created_at) credited_at FROM transactions WHERE user_id=? AND type='deposit' AND status='success' ORDER BY (financial_seq IS NOT NULL),financial_seq,COALESCE(processed_at,created_at),bonus DESC,id LIMIT 1",[$uid]);
    $firstAfter=$first && (isset($first['financial_seq']) ? ($boundary['seq']===null || (int)$first['financial_seq']>$boundary['seq']) : $first['credited_at']>=$since);
    $required=bbTurnoverRequired($w,(float)$dep['a'],(float)$dep['b'],$firstAfter?(float)$first['bonus']:0,$other);
    return ['enabled'=>!empty($w['enabled']),'since'=>$boundary['hasBoundary']?$since:null,'financialSeq'=>$boundary['seq'],'deposits'=>(float)$dep['a'],'depositBonus'=>(float)$dep['b'],'otherBonus'=>$other,'required'=>$required,'completed'=>$bets,'remaining'=>max(0.0,round($required-$bets,2)),'rules'=>$w];
}
}
if ($action === 'turnover' && $method === 'GET') Database::jsonResponse(['success' => true] + bbTurnoverStatus($userId));
