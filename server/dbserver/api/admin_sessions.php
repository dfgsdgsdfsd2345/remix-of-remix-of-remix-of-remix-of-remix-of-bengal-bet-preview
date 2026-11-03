<?php
/** Operator-only session issuance. The master credential never enters a browser. */
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
if(!Database::verifyMasterKey())Database::errorResponse('Unauthorized operator.',401);
if(($_SERVER['REQUEST_METHOD']??'')!=='POST')Database::errorResponse('Method Not Allowed',405);
$input=Database::getJsonInput();
if(($input['action']??'')==='revoke'){
    Database::execute('UPDATE admin_scoped_sessions SET revoked_at=? WHERE id=?',[date('Y-m-d H:i:s'),(string)($input['id']??'')]);
    Database::jsonResponse(['success'=>true]);
}
if(($input['action']??'')!=='issue')Database::errorResponse('Unsupported operation',400);
$token='adm_'.bin2hex(random_bytes(32));$id='adm-'.bin2hex(random_bytes(12));
Database::insert('admin_scoped_sessions',['id'=>$id,'token_hash'=>hash('sha256',$token),'expires_at'=>date('Y-m-d H:i:s',time()+3600),'created_at'=>date('Y-m-d H:i:s')]);
header('Cache-Control: no-store');
Database::jsonResponse(['success'=>true,'id'=>$id,'token'=>$token]);