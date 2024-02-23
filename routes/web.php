<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Execute git log command to get commit history
    $output = shell_exec('git log --stat'); // --stat option shows statistics for each commit
    $commitHashes = explode("\n", trim($output));
    // Split output into individual commits
    $commits = explode('commit ', $output);
    // foreach ($commits as $commit) {
    //     // Skip empty lines
    //     if (empty(trim($commit))) {
    //         continue;
    //     }

    //     // Split commit information into lines
    //     $lines = explode("\n", $commit);

    //     // Extract commit hash, author, date, and commit message
    //     $commitHash = trim(substr($lines[0], 6)); // Remove 'commit ' prefix
    //     $authorLine = $lines[1];
    //     $dateLine = $lines[2];
    //     $commitMessage = trim(implode("\n", array_slice($lines, 4))); // Skip first three lines

    //     echo "Commit: $commitHash\n";
    //     echo "Author: $authorLine\n";
    //     echo "Date: $dateLine\n";
    //     echo "Message: $commitMessage\n";

    //     // Extract changes made in this commit
    //     $changes = [];
    //     foreach ($lines as $line) {
    //         if (strpos($line, 'changed') !== false) {
    //             $changes[] = $line;
    //         }
    //     }

    //     // Display changes
    //     if (!empty($changes)) {
    //         echo "Changes:\n";
    //         foreach ($changes as $change) {
    //             echo "<pre>" . "- $change \n" . "</pre>";
    //         }
    //     }

    //     echo "\n";
    // }
    $output = shell_exec("git show --stat --patch --no-color $commitHashes[3]");
    print_r("<pre>" . $output . "</pre>");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
