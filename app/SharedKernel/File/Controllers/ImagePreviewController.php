<?php

declare(strict_types=1);

namespace App\SharedKernel\File\Controllers;

use App\SharedKernel\File\Models\FileRepository;

final class ImagePreviewController extends \Phalcon\Mvc\Controller
{
    public function mainAction($id): void
    {
        $file = (new FileRepository())->get($id);

        header('Cache-Control: No-Store');
        header('Content-Type:' . $file->mime_type);
        header('Content-Length: ' . filesize($file->placement));
        readfile($file->placement);
    }
}
