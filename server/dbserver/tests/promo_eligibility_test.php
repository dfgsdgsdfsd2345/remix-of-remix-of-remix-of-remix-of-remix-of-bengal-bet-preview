<?php
require __DIR__.'/../api/reward_grants.php';
class Database {
    static float $deposit=0;
    static float $bet=0;
    static bool $granted=false;
    static int $writes=0;
    static function fetchOne($sql,$params=[]) {
        if(str_contains($sql,'SUM(amount)'))return ['t'=>self::$deposit];
        if(str_contains($sql,'SUM(valid_bet)')) {
            if(!str_contains($sql,"category IN ('slot','fishing')"))throw new RuntimeException('Eligible categories changed');
            return ['t'=>self::$bet];
        }
        if(str_contains($sql,'FROM transactions'))return self::$deposit>0?['id'=>'approved']:null;
        if(str_contains($sql,'config_json')||str_contains($sql,'FROM site_settings'))return null;
        throw new RuntimeException('Unexpected eligibility query');
    }
    static function execute($sql,$params=[]) {
        if(str_contains($sql,'INSERT IGNORE')) {
            if(self::$granted)return 0;
            self::$granted=true;return 1;
        }
        self::$writes++;return 1;
    }
}
function eligibilityCheck($condition,$label) {
    if(!$condition)throw new RuntimeException($label);
    echo "$label passed\n";
}
Database::$deposit=199;Database::$bet=1000;
eligibilityCheck(!bbDailyLoginEgg('test')&&Database::$writes===0,'Deposit 199 cannot grant login hammer');
Database::$deposit=200;Database::$bet=999;
eligibilityCheck(!bbDailyLoginEgg('test')&&Database::$writes===0,'Valid bet 999 cannot grant login hammer');
Database::$bet=1000;
eligibilityCheck(bbDailyLoginEgg('test')&&Database::$writes===1,'Deposit 200 and valid bet 1000 grant one hammer');
eligibilityCheck(!bbDailyLoginEgg('test')&&Database::$writes===1,'Same-day hammer cannot grant twice');
eligibilityCheck(BB_APP_BONUS_MIN_DEPOSIT===500&&BB_APP_BONUS_MIN_BET===5000,'App requires deposit 500 and slot/fishing valid bet 5000');
eligibilityCheck(bbReferralSettings()['minDepositToQualify']===300.0&&bbReferralSettings()['minBetTurnoverToQualify']===3000.0,'Referral defaults require deposit 300 and bet 3000');