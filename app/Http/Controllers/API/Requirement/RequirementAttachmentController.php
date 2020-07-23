<?php

namespace App\Http\Controllers\API\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Attachment\AttachmentResource;
use App\Models\Requirement\Requirement;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class RequirementAttachmentController extends Controller
{
    public function index(Requirement $requirement)
    {
        return AttachmentResource::collection($requirement->getMedia('requirement-attachments'));
    }

    public function store(Request $request, Requirement $requirement)
    {
        try {
            $requirement->addMedia($request->file)
                ->toMediaCollection('requirement-attachments');
        } catch (FileDoesNotExist $e) {
            return $e;
        } catch (FileIsTooBig $e) {
            return $e;
        }

        return response()->json(['message' => 'File uploaded']);
    }
}
