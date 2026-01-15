<?php

namespace App\Modules\OpenImmo\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\OpenImmo\Services\ZipHandler;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Admin Import Log Controller
 * 
 * Displays OpenImmo import history and status in admin panel.
 */
class ImportLogController extends BaseController
{
    protected ZipHandler $zipHandler;

    public function __construct()
    {
        $this->zipHandler = new ZipHandler();
    }

    /**
     * Display import logs and status.
     */
    public function index(): string
    {
        // Get recent logs
        $logPath = WRITEPATH . 'logs/openimmo_imports.log';
        $logs = [];

        if (file_exists($logPath)) {
            $rawLogs = array_slice(file($logPath, FILE_IGNORE_NEW_LINES), -50);
            $logs = array_reverse($rawLogs);
        }

        // Get pending files
        $pendingFiles = $this->zipHandler->getPendingFiles();

        // Get import directory info
        $importDir = $this->zipHandler->getImportDir();
        $processedDir = $importDir . '/processed';
        $processedCount = 0;

        if (is_dir($processedDir)) {
            $processedCount = count(glob($processedDir . '/*.zip'));
        }

        $data = [
            'title' => 'OpenImmo Import Logs',
            'logs' => $logs,
            'pendingCount' => count($pendingFiles),
            'pendingFiles' => array_map('basename', $pendingFiles),
            'processedCount' => $processedCount,
            'importDir' => $importDir,
        ];

        return view('App\Modules\OpenImmo\Views\admin\import_logs', $data);
    }
}
