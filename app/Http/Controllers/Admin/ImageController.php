<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;

class ImageController extends Controller
{
    public function destroy(Image $image): RedirectResponse
    {
        ImageService::destroy($image);

        return
            redirect()
                ->back()
                ->with([
                    'success' => 'Image deleted successfully!',
                ]);
    }
}
