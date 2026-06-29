<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$u = App\Models\User::first();
if ($u) {
    $u->permissions = ['qc.upload', 'qc.manual', 'qc.history', 'products.index', 'inventory.index', 'inventory.mutations', 'reports.index', 'users.index'];
    $u->save();
    echo "Permissions assigned to user 1.\n";
} else {
    echo "No user found.\n";
}
