<?php
require __DIR__.'/../api/vip_salary.php';
class SalaryConnection {
    public bool $active=false;
    function beginTransaction(){ $this->active=true; }
    function commit(){ $this->active=false; }
    function inTransaction(){ return $this->active; }
    function rollBack(){ $this->active=false; }
}
class Database {
    static array $jobs=[];
    static array $users=[['id'=>'usr-a','created_at'=>'2026-12-01 10:00:00'],['id'=>'usr-z','created_at'=>'2026-12-01 15:00:01']];
    static function getConnection(){ return new SalaryConnection(); }
    static function fetchOne($sql,$params=[]){
        if(str_contains($sql,'checked_date')) return ['checked_date'=>'2026-12-01'];
        if(str_contains($sql,'MAX(id)')){
            $ids=array_column(array_filter(self::$users,fn($u)=>$u['created_at']<=$params[0]),'id');
            return ['upper_id'=>$ids?max($ids):null];
        }
        throw new RuntimeException('Unexpected test query');
    }
    static function execute($sql,$params=[]){
        if(str_contains($sql,'INSERT IGNORE')) self::$jobs[]=$params;
    }
}
$live=['promoRules'=>['vip'=>['weeklyClaimDay'=>1,'monthlyClaimDay'=>1,'monthlyHour'=>15]],'vipTiers'=>[]];
bbSalaryPrepare($live,'2026-12-01','2026-12-01 00:01:00');
if(Database::$jobs!==[])throw new RuntimeException('Monthly job froze before 15:00');
bbSalaryPrepare($live,'2026-12-01','2026-12-01 15:00:00');
if(count(Database::$jobs)!==1 || Database::$jobs[0][3]!=='2026-12-01 15:00:00' || Database::$jobs[0][5]!=='usr-a')throw new RuntimeException('Due-time eligibility excluded 10:00 member or included post-due member');
echo "Monthly preparation at 15:00 includes pre-due members and excludes post-due members passed\n";