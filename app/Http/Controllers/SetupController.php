<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\EnvironmentWriter;
use App\Support\Installer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use PDOException;
use Throwable;

class SetupController extends Controller
{
    public function welcome(): View
    {
        return view('setup.welcome', [
            'checks' => $this->runRequirementChecks(),
        ]);
    }

    public function proceedFromWelcome(): RedirectResponse
    {
        $checks = $this->runRequirementChecks();

        if (collect($checks)->contains(fn ($check) => ! $check['passed'])) {
            return redirect()->route('setup.welcome')->with('error', 'Please resolve the failing requirements above before continuing.');
        }

        session(['setup.requirements_passed' => true]);

        return redirect()->route('setup.database');
    }

    public function database(): View|RedirectResponse
    {
        if (! session('setup.requirements_passed')) {
            return redirect()->route('setup.welcome');
        }

        return view('setup.database', [
            'current' => [
                'driver' => env('DB_CONNECTION', 'mysql'),
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'rjs_pharma'),
                'username' => env('DB_USERNAME', 'root'),
            ],
        ]);
    }

    public function testAndSaveDatabase(Request $request): RedirectResponse
    {
        if (! session('setup.requirements_passed')) {
            return redirect()->route('setup.welcome');
        }

        $validated = $request->validate([
            'driver' => ['required', 'in:mysql,sqlite'],
            'host' => ['required_if:driver,mysql', 'nullable', 'string'],
            'port' => ['required_if:driver,mysql', 'nullable', 'string'],
            'database' => ['required_if:driver,mysql', 'nullable', 'string'],
            'username' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
        ]);

        $driver = $validated['driver'];

        try {
            if ($driver === 'sqlite') {
                $sqlitePath = database_path('database.sqlite');
                if (! file_exists($sqlitePath)) {
                    touch($sqlitePath);
                }

                config(['database.default' => 'sqlite']);
                config(['database.connections.sqlite.database' => $sqlitePath]);
                DB::purge('sqlite');
                DB::connection('sqlite')->getPdo();

                EnvironmentWriter::set(['DB_CONNECTION' => 'sqlite']);
            } else {
                config([
                    'database.default' => 'mysql',
                    'database.connections.mysql.host' => $validated['host'],
                    'database.connections.mysql.port' => $validated['port'],
                    'database.connections.mysql.database' => $validated['database'],
                    'database.connections.mysql.username' => $validated['username'] ?? '',
                    'database.connections.mysql.password' => $validated['password'] ?? '',
                ]);
                DB::purge('mysql');
                DB::connection('mysql')->getPdo();

                EnvironmentWriter::set([
                    'DB_CONNECTION' => 'mysql',
                    'DB_HOST' => $validated['host'],
                    'DB_PORT' => $validated['port'],
                    'DB_DATABASE' => $validated['database'],
                    'DB_USERNAME' => $validated['username'] ?? '',
                    'DB_PASSWORD' => $validated['password'] ?? '',
                ]);
            }
        } catch (PDOException $e) {
            return redirect()->route('setup.database')
                ->withInput()
                ->with('error', 'Could not connect to the database: '.$e->getMessage());
        }

        session(['setup.database_configured' => true]);

        return redirect()->route('setup.install');
    }

    public function install(): View|RedirectResponse
    {
        if (! session('setup.database_configured')) {
            return redirect()->route('setup.database');
        }

        return view('setup.install', [
            'ran' => session('setup.install_output'),
        ]);
    }

    public function runInstall(): RedirectResponse
    {
        if (! session('setup.database_configured')) {
            return redirect()->route('setup.database');
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = Artisan::output();

            Artisan::call('db:seed', ['--force' => true]);
            $seedOutput = Artisan::output();
        } catch (Throwable $e) {
            return redirect()->route('setup.install')
                ->with('error', 'Installation failed: '.$e->getMessage());
        }

        session([
            'setup.installed' => true,
            'setup.install_output' => trim($migrateOutput."\n".$seedOutput),
        ]);

        return redirect()->route('setup.install');
    }

    public function admin(): View|RedirectResponse
    {
        if (! session('setup.installed')) {
            return redirect()->route('setup.install');
        }

        return view('setup.admin');
    }

    public function createAdmin(Request $request): RedirectResponse
    {
        if (! session('setup.installed')) {
            return redirect()->route('setup.install');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validated['email'] !== 'admin@rjspharma.in') {
            User::where('email', 'admin@rjspharma.in')->delete();
        }

        User::updateOrCreate(
            ['email' => $validated['email']],
            ['name' => $validated['name'], 'password' => Hash::make($validated['password'])]
        );

        session(['setup.admin_created' => true]);

        return redirect()->route('setup.finish');
    }

    public function finish(): View|RedirectResponse
    {
        if (! session('setup.admin_created')) {
            return redirect()->route('setup.admin');
        }

        Installer::markInstalled();

        $setupKeys = array_filter(array_keys(session()->all()), fn ($key) => str_starts_with($key, 'setup.'));
        session()->forget($setupKeys);

        return view('setup.finish');
    }

    /**
     * @return array<int, array{label: string, passed: bool, hint: ?string}>
     */
    private function runRequirementChecks(): array
    {
        $checks = [
            ['label' => 'PHP 8.2 or higher', 'passed' => version_compare(PHP_VERSION, '8.2.0', '>='), 'hint' => 'Current: '.PHP_VERSION],
        ];

        foreach (['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json'] as $ext) {
            $checks[] = ['label' => "PHP extension: {$ext}", 'passed' => extension_loaded($ext), 'hint' => null];
        }

        $writablePaths = [
            'storage/' => storage_path(),
            'storage/framework/' => storage_path('framework'),
            'storage/framework/cache/' => storage_path('framework/cache'),
            'storage/framework/sessions/' => storage_path('framework/sessions'),
            'storage/framework/views/' => storage_path('framework/views'),
            'storage/logs/' => storage_path('logs'),
            'storage/app/' => storage_path('app'),
            'bootstrap/cache/' => base_path('bootstrap/cache'),
        ];

        foreach ($writablePaths as $label => $path) {
            $checks[] = ['label' => "Writable: {$label}", 'passed' => is_dir($path) && is_writable($path), 'hint' => null];
        }

        $checks[] = ['label' => '.env file is writable', 'passed' => is_writable(base_path('.env')), 'hint' => null];

        return $checks;
    }
}
