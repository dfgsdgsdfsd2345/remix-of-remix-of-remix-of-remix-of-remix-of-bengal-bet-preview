<?php
/**
 * BengalBet DB Server - Central API Gateway & Front Controller
 * Target URL: https://deserver.neexthub.site/dbserver/
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

// Parse Requested Route
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$uri = parse_url($uri, PHP_URL_PATH);

// Strip prefix if any (e.g., /dbserver/ or /dbserver/api/)
$cleanPath = preg_replace('#^/dbserver/?#', '', $uri);
$cleanPath = preg_replace('#^api/?#', '', $cleanPath);
$cleanPath = trim($cleanPath, '/');

// Check if route passed via query param (e.g. ?route=auth/login or ?endpoint=wallet/balance)
if (empty($cleanPath)) {
    $cleanPath = trim($_GET['route'] ?? $_GET['endpoint'] ?? '', '/');
}

// Check for Master API call
if ($cleanPath === 'masterapi' || $cleanPath === 'masterapi.php' || isset($_GET['master']) || ($cleanPath === '' && !empty($_GET['action']) && in_array($_GET['action'], ['ping', 'status', 'list_files', 'get_file', 'create_file', 'update_file', 'save_file', 'delete_file', 'create_dir', 'db_tables', 'db_table_data', 'db_query', 'db_schema', 'db_insert_row', 'db_update_row', 'db_delete_row', 'db_import_sql', 'db_reset', 'sync_patch', 'batch_update_files']))) {
    require __DIR__ . '/masterapi.php';
    exit();
}

// Root health check / status
if (empty($cleanPath)) {
    Database::jsonResponse([
        'status' => 'online',
        'service' => 'BengalBet REST API & DB Server',
        'domain' => 'https://deserver.neexthub.site/',
        'path' => '/dbserver/',
        'time' => date('Y-m-d H:i:s'),
        'version' => '3.0.0',
        'endpoints' => [
            '/api/auth' => 'Login, Registration, Profiles',
            '/api/wallet' => 'Balance, Deposits, Withdrawals, Cards',
            '/api/games' => 'Bet Recording, History, Profit/Loss',
            '/api/rewards' => 'Spins, Golden Eggs, Red Envelopes',
            '/api/messages' => 'Inbox Notices, Bonus Claims',
            '/api/feedback' => 'Support Tickets & Helpdesk',
            '/api/chat' => 'Live Chat 24/7 Service',
            '/api/settings' => 'Public Gateways & Notices',
            '/api/referral' => 'Affiliate Program & Commissions',
            '/api/vip' => 'VIP Levels & Perks',
            '/api/daily-signin' => 'Daily Attendance Bonuses',
            '/api/rescue' => 'Loss Rescue Fund',
            '/api/promos' => 'Promo Codes & Vouchers',
            '/api/tickets' => 'User Lottery & Reward Tickets',
            '/api/mystery-reward' => '23rd Mystery Cash Cards',
            '/api/admin' => 'Admin Management Dashboard',
            '/masterapi.php' => 'Master Remote Files & MySQL Controller'
        ]
    ]);
}

// Explode clean path segments
$parts = explode('/', $cleanPath);
$module = $parts[0] ?? '';
$action = $parts[1] ?? '';
$paramId = $parts[2] ?? '';

// Support /module/{id}/{action} as well as /module/{action}/{id}
$idActions = ['read', 'claim', 'delete', 'message', 'resolve', 'ticket'];
if ($paramId !== '' && in_array($paramId, $idActions, true) && !in_array($action, $idActions, true)) {
    [$action, $paramId] = [$paramId, $action];
} elseif ($paramId === '' && $action !== '' && in_array($module, ['feedback', 'messages'], true)
    && !in_array($action, ['list', 'submit', 'create', 'read', 'claim', 'delete', 'message', 'resolve', 'ticket'], true)) {
    $paramId = $action;
    $m = $_SERVER['REQUEST_METHOD'];
    $action = $module === 'feedback' ? 'ticket' : ($m === 'DELETE' ? 'delete' : 'read');
}
if ($action !== '') $_GET['action'] = $action;
if (!empty($paramId)) {
    $_GET['id'] = $paramId;
    if ($module === 'chat' && $action === 'messages' && empty($_GET['sessionId'])) $_GET['sessionId'] = $paramId;
}

switch ($module) {
    case 'auth':
        require __DIR__ . '/api/auth.php';
        break;

    case 'wallet':
        require __DIR__ . '/api/wallet.php';
        break;

    case 'games':
        require __DIR__ . '/api/games.php';
        break;

    case 'rewards':
        require __DIR__ . '/api/rewards.php';
        break;

    case 'messages':
        require __DIR__ . '/api/messages.php';
        break;

    case 'feedback':
        require __DIR__ . '/api/feedback.php';
        break;

    case 'chat':
        require __DIR__ . '/api/chat.php';
        break;

    case 'settings':
        require __DIR__ . '/api/settings.php';
        break;

    case 'referral':
        require __DIR__ . '/api/referral.php';
        break;

    case 'vip':
        require __DIR__ . '/api/vip.php';
        break;

    case 'daily-signin':
    case 'daily_signin':
        require __DIR__ . '/api/daily_signin.php';
        break;

    case 'rescue':
        require __DIR__ . '/api/rescue.php';
        break;

    case 'promos':
        require __DIR__ . '/api/promos.php';
        break;

    case 'tickets':
        require __DIR__ . '/api/tickets.php';
        break;

    case 'mystery-reward':
    case 'mystery_reward':
        require __DIR__ . '/api/mystery_reward.php';
        break;

    case 'admin':
        // Normalize /admin/{section}/{id}/{action}, /admin/{section}/{action}/{id} and /admin/chat/sessions/{id}/{action}
        $known = ['create','sync','details','update','status','balance','vip','delete','batch','reply','sessions','session','credit','stats','list','message','reset-cooldowns','edit','assign','note','settings','bonus-payout','claims','config','records','tiers','cards','redemptions','manual-credit','reset-streak','review','manual-grant','override-user','trigger-drop','manual-issue','new-member-config'];
        $rest = array_values(array_filter(array_slice($parts, 2), fn($p) => $p !== ''));
        $reqMethod = $_SERVER['REQUEST_METHOD'];
        $act = ''; $tid = '';
        if (($parts[1] ?? '') === 'chat' && ($rest[0] ?? '') === 'sessions' && isset($rest[1])) {
            $tid = $rest[1];
            $act = $rest[2] ?? ($reqMethod === 'DELETE' ? 'delete' : 'session');
        } elseif (count($rest) === 1) {
            if (in_array($rest[0], $known, true)) { $act = $rest[0]; }
            else { $tid = $rest[0]; $act = $reqMethod === 'DELETE' ? 'delete' : ($reqMethod === 'GET' ? 'details' : 'update'); }
        } elseif (count($rest) >= 2) {
            if (in_array($rest[1], $known, true)) { $tid = $rest[0]; $act = $rest[1]; }
            else { $act = $rest[0]; $tid = $rest[1]; }
        }
        unset($_GET['id']);
        $_GET['section'] = $parts[1] ?? '';
        $_GET['action'] = $act;
        if ($tid !== '') $_GET['id'] = $tid;
        require __DIR__ . '/api/admin.php';
        break;

    case 'master':
    case 'masterapi':
        require __DIR__ . '/masterapi.php';
        break;

    default:
        Database::errorResponse("Endpoint not found: /api/{$cleanPath}", 404);
        break;
}
