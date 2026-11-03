<?php
/** Authenticated operational regression; all financial rows roll back. Never run on ordinary members. */
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
Database::requireAdmin();
$input=Database::getJsonInput();$uid=(string)($input['userId']??'');
if(!preg_match('/^usr-[a-f0-9]{10}$/',$uid))Database::errorResponse('Isolated test member required',400);
$action='test';$method='POST';require_once __DIR__.'/../api/turnover_guard.php';
$pdo=Database::getConnection();$checks=[];
function verifyOrder(bool $ok,string $label):void {global $checks;if(!$ok)throw new RuntimeException($label);$checks[]=$label;}
try {
 $before=Database::fetchOne('SELECT seq FROM financial_clocks WHERE user_id=?',[$uid]);
 $pdo->beginTransaction();$u=Database::fetchOne('SELECT * FROM users WHERE id=? FOR UPDATE',[$uid]);
 if(!$u)throw new RuntimeException('Test member missing');
 $stamp=date('Y-m-d H:i:s');
 $base=['user_id'=>$uid,'username'=>$u['username'],'user_phone'=>$u['phone'],'channel'=>'system','status'=>'success','created_at'=>$stamp];
 $withdraw='audit-'.bin2hex(random_bytes(10));
 Database::insert('transactions',array_merge($base,['id'=>$withdraw,'type'=>'withdraw','amount'=>500,'status'=>'pending','description'=>'isolated rollback boundary']));
 $state=bbTurnoverStatus($uid);verifyOrder($state['remaining']===0.0,'Same-second withdrawal does not recount earlier sequenced credits');
 $bonus='audit-'.bin2hex(random_bytes(10));
 Database::insert('transactions',array_merge($base,['id'=>$bonus,'type'=>'bonus','amount'=>50,'description'=>'isolated rollback bonus']));
 $state=bbTurnoverStatus($uid);verifyOrder($state['remaining']===50.0,'Same-second later bonus requires exactly 50 turnover');
 $bet=Database::fetchOne('SELECT * FROM bets WHERE user_id=? LIMIT 1',[$uid]);if(!$bet)throw new RuntimeException('Test bet fixture missing');
 $bet['id']='audit-'.bin2hex(random_bytes(10));$bet['valid_bet']=50;$bet['bet_amount']=50;$bet['reward']=0;$bet['time']=$stamp;$bet['date']=substr($stamp,0,10);unset($bet['financial_seq']);
 Database::insert('bets',$bet);
 $state=bbTurnoverStatus($uid);verifyOrder($state['remaining']===0.0,'Same-second later bet satisfies the later bonus');
 $seqs=Database::fetchAll('SELECT financial_seq FROM transactions WHERE id IN (?,?)',[$withdraw,$bonus]);
 verifyOrder(count($seqs)===2 && $seqs[0]['financial_seq']!==$seqs[1]['financial_seq'],'Cash events have distinct sequence numbers');
 $pdo->rollBack();$after=Database::fetchOne('SELECT seq FROM financial_clocks WHERE user_id=?',[$uid]);
 verifyOrder($before===$after,'Rollback restores clock with no partial event');
 verifyOrder(!Database::fetchOne('SELECT id FROM transactions WHERE id=?',[$bonus]),'Rollback removes test bonus ledger');
 Database::jsonResponse(['success'=>true,'checks'=>$checks]);
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();Database::errorResponse($e->getMessage(),400);}