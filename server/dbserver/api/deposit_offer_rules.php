<?php
/** Deposit offer rules. Keep identical to src/bengalbet/services/depositOffer.ts. */
function bbDepositOfferDefaults(): array {
    $t=[];foreach([[100,47],[200,77],[500,177],[1000,277],[5000,1577],[10000,2777],[50000,17777],[100000,37777]] as [$m,$b])$t[]=['minDeposit'=>(float)$m,'bonus'=>(float)$b];
    return ['enabled'=>true,'bonusPercent'=>47.0,'maxBonus'=>37777.0,'firstDepositOnly'=>true,'minDepositForBonus'=>100.0,'tiers'=>$t];
}
function bbValidateDepositOffer($c): array {
    if(!is_array($c)) throw new InvalidArgumentException('Invalid deposit offer');
    foreach(['enabled','firstDepositOnly'] as $k) if(!isset($c[$k]) || !is_bool($c[$k])) throw new InvalidArgumentException('Invalid '.$k);
    $out=['enabled'=>$c['enabled'],'firstDepositOnly'=>$c['firstDepositOnly']];
    foreach(['bonusPercent'=>100,'maxBonus'=>100000000,'minDepositForBonus'=>100000000] as $k=>$max){
        $v=$c[$k] ?? null;
        if(!is_numeric($v) || !is_finite((float)$v) || $v<0 || $v>$max) throw new InvalidArgumentException('Invalid '.$k);
        $out[$k]=round((float)$v,2);
    }
    $t=$c['tiers'] ?? [];
    if(!is_array($t) || count($t)>40) throw new InvalidArgumentException('Invalid tiers');
    $out['tiers']=[];$prev=-1;
    foreach(array_values($t) as $x){
        $m=$x['minDeposit'] ?? null;$b=$x['bonus'] ?? null;
        if(!is_numeric($m)||!is_numeric($b)||$m<=$prev||$m<1||$b<0||$m>100000000||$b>100000000) throw new InvalidArgumentException('Invalid tiers');
        $out['tiers'][]=['minDeposit'=>round((float)$m,2),'bonus'=>round((float)$b,2)];$prev=(float)$m;
    }
    return $out;
}
function bbDepositOffer(): array {
    $row=Database::fetchOne('SELECT config_json FROM deposit_offer_config WHERE id=1');
    if(!$row) return bbDepositOfferDefaults();
    try { return bbValidateDepositOffer(json_decode($row['config_json'],true)); }
    catch(InvalidArgumentException $e) { return ['enabled'=>false,'bonusPercent'=>0.0,'maxBonus'=>0.0,'firstDepositOnly'=>true,'minDepositForBonus'=>0.0]; }
}
function bbDepositBonus(array $offer,float $amount,bool $optIn,bool $hasPriorDeposit): float {
    if(empty($offer['enabled']) || !$optIn || !is_finite($amount) || $amount<=0) return 0.0;
    if($amount < (float)$offer['minDepositForBonus']) return 0.0;
    if(!empty($offer['firstDepositOnly']) && $hasPriorDeposit) return 0.0;
    $bonus=round($amount*(float)$offer['bonusPercent'])/100;
    if(!empty($offer['tiers'])){ $bonus=0.0; foreach($offer['tiers'] as $t) if($amount>=(float)$t['minDeposit']) $bonus=(float)$t['bonus']; }
    if((float)$offer['maxBonus']>0) $bonus=min($bonus,(float)$offer['maxBonus']);
    return round($bonus,2);
}
