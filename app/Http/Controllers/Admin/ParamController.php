<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Param\StoreRequest;
use App\Http\Requests\Admin\Param\UpdateRequest;
use App\Http\Resources\Param\ParamResource;
use App\Models\Param;
use App\Services\ParamService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $params = Param::all();
        $params = ParamResource::collection($params)->resolve();

        return inertia('admin/param/Index', compact('params'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {

        return inertia('admin/param/Create', [
            'filterTypes' => ParamFilterTypeEnum::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        ParamService::store($data);

        return redirect()
            ->back()
            ->with('success', 'Param created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Param $param): Response
    {
        $param = ParamResource::make($param)->resolve();

        return inertia('admin/param/Show', compact('param'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Param $param): Response
    {
        $param = ParamResource::make($param)->resolve();
        $filterTypes = ParamFilterTypeEnum::options();

        return inertia('admin/param/Edit', compact('param', 'filterTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Param $param): RedirectResponse
    {
        $data = $request->validated();
        ParamService::update($param, $data);

        return redirect()
            ->back()
            ->with('success', 'Param updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Param $param): RedirectResponse
    {
        $param->delete();

        return redirect()
            ->back()
            ->with('success', 'Param deleted successfully!');
    }
}
