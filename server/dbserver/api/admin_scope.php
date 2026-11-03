<?php
/** Temporary configuration-test scope: never financial, member, master or scheduler authority. */
function bbAdminScopeAllows(string $section,string $action,string $method): bool {
    if($method==='GET' && in_array($section,['stats','salary-stats'],true) && $action==='')return true;
    if($method==='GET' && $section==='vip' && in_array($action,['tiers','stats','claims'],true))return true;
    if($section==='daily-signin' && in_array($action,['config','new-member-config'],true))return in_array($method,['GET','POST','DELETE'],true);
    if(in_array($section,['deposit-offer','promo-rules','promo-content','mystery-reward','chance-rewards'],true) && $action==='config')return in_array($method,['GET','POST','DELETE'],true);
    return false;
}
function bbAdminSessionActive(array $row,int $now): bool {
    return empty($row['revoked_at']) && isset($row['expires_at']) && strtotime($row['expires_at'])>$now;
}
function bbRequireScopedAdmin(): void {
    $token=$_SERVER['HTTP_X_ADMIN_TOKEN']??'';
    if(!is_string($token)||!preg_match('/^adm_[a-f0-9]{64}$/',$token))Database::errorResponse('Unauthorized admin request.',401);
    $row=Database::fetchOne('SELECT expires_at,revoked_at FROM admin_scoped_sessions WHERE token_hash=?',[hash('sha256',$token)]);
    if(!$row||!bbAdminSessionActive($row,time()))Database::errorResponse('Admin session expired or revoked.',401);
    if(!bbAdminScopeAllows((string)($_GET['section']??''),(string)($_GET['action']??''),(string)($_SERVER['REQUEST_METHOD']??'')))Database::errorResponse('Operation outside administrator scope.',403);
}