<?php
/** An account password can change only with its actual configured password. */
function bbPasswordChangeAllowed(?string $hash, string $oldPassword): bool {
    return !empty($hash) && password_verify($oldPassword, $hash);
}