<?php
require __DIR__.'/../api/password_policy.php';
$hash=password_hash('isolated-account-password', PASSWORD_BCRYPT);
if(bbPasswordChangeAllowed($hash,'123456'))throw new RuntimeException('Legacy universal password must not authorize a change');
if(bbPasswordChangeAllowed(null,'123456'))throw new RuntimeException('Missing password must fail closed');
if(!bbPasswordChangeAllowed($hash,'isolated-account-password'))throw new RuntimeException('Correct account password must authorize a change');
echo "Password policy assertions passed\n";