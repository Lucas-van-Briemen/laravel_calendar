<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $databases = $this->getDatabases();
        $databases = json_decode($databases);
        return view('database.index', [
            'databases' => $databases
        ]);
    }

    public function getDatabases()
    {
        $databases = DB::select('SHOW DATABASES');
        return json_encode($databases);
    }

    public function getTables($database)
    {
        $tables = DB::select('SHOW TABLES FROM ' . $database);
        return json_encode($tables);
    }
}
