<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateChecklistRequest;
use App\Http\Requests\GetChecklistsRequest;
use App\Http\Resources\ChecklistCollection;
use App\Http\Resources\ChecklistDetailResource;
use App\Http\Resources\ChecklistResource;
use App\Models\Checklist;

class ChecklistController extends Controller
{
    public function index(GetChecklistsRequest $request)
    {
        return new ChecklistCollection(auth()->user()->checklists()->paginate($request->input('count')));
    }

    public function store(CreateChecklistRequest $request)
    {
        return new ChecklistResource(Checklist::createChecklist($request->only('name'), auth()->user()));
    }

    public function update(CreateChecklistRequest $request, Checklist $checklist)
    {
        $this->authorize('update', $checklist);
        return new ChecklistResource($checklist->updateChecklist($request->only('name')));
    }

    public function show(Checklist $checklist)
    {
        $this->authorize('show', $checklist);
        return new ChecklistDetailResource($checklist);
    }

    public function destroy(Checklist $checklist)
    {
        $this->authorize('destroy', $checklist);
        $checklist->deleteChecklist();
        return response()->json([], 204);
    }
}
