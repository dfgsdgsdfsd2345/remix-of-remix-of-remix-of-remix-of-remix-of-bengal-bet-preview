<?php
require __DIR__.'/../api/admin_scope.php';
function scopeCheck($ok,$label){if(!$ok)throw new RuntimeException($label);}
scopeCheck(bbAdminScopeAllows('daily-signin','new-member-config','DELETE'),'Task reset permitted');
scopeCheck(bbAdminScopeAllows('daily-signin','config','POST'),'Daily config save permitted');
scopeCheck(bbAdminScopeAllows('salary-stats','','GET'),'Salary statistics read permitted');
foreach([['users','balance','POST'],['transactions','status','POST'],['cron','run','POST'],['mystery-reward','manual-issue','POST'],['master','','GET'],['vip','tiers','DELETE']] as $tuple)scopeCheck(!bbAdminScopeAllows(...$tuple),'Nonconfiguration authority denied');
scopeCheck(!bbAdminSessionActive(['expires_at'=>'2026-11-03 12:00:00'],strtotime('2026-11-03 12:00:00')),'Expiry exact boundary denied');
scopeCheck(!bbAdminSessionActive(['expires_at'=>'2026-11-04','revoked_at'=>'2026-11-03'],strtotime('2026-11-03')),'Revocation immediate');
scopeCheck(bbAdminSessionActive(['expires_at'=>'2026-11-04','revoked_at'=>null],strtotime('2026-11-03')),'Valid session allowed');
echo "Scoped administrator boundaries passed\n";