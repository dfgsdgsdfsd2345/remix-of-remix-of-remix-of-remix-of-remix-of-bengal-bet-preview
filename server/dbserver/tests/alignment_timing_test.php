<?php
require __DIR__.'/../api/promo_rules.php';
function verify($ok, $name) { if (!$ok) throw new RuntimeException($name); echo "$name passed\n"; }
$r=bbPromoRulesDefaults();
verify($r['redPacket']['hours']===[0,2,4,6,8,10,12,14,16,18,20,22], 'Twelve two-hour rounds');
verify($r['memberDay']['claimFromHour']===12, 'Member day starts at noon');
$tz=new DateTimeZone('Asia/Dhaka');
$at=fn($s)=>(new DateTimeImmutable($s,$tz))->getTimestamp();
verify(!bbMemberDayOpen($r['memberDay'],$at('2026-11-13 11:59:59')), 'Member day before noon denied');
verify(bbMemberDayOpen($r['memberDay'],$at('2026-11-13 12:00:00')), 'Member day noon accepted');
verify(!bbMemberDayOpen($r['memberDay'],$at('2026-11-14 12:00:00')), 'Other date denied');
$c=$r['rescue']; $c['claimFromHour']=22; $c['claimWindowHours']=24;
$w=bbRescueWindow($c,$at('2026-11-03 21:59:59'));
verify($w['date']==='2026-11-01', 'Before 22 uses previous open loss period');
$w=bbRescueWindow($c,$at('2026-11-03 22:00:00'));
verify($w['date']==='2026-11-02' && $w['opensAt']==='2026-11-03 22:00:00' && $w['expiresAt']==='2026-11-04 22:00:00', 'Rescue 22 start and twenty-four hour deadline');
$w=bbRescueWindow($c,$at('2026-11-04 22:00:00'));
verify($w['date']==='2026-11-03', 'At deadline advances period without extending old period');