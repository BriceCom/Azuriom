<?php

namespace Azuriom\Plugin\Achievement\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Role;
use Azuriom\Models\Server;
use Azuriom\Plugin\Achievement\Models\Objective;
use Azuriom\Plugin\Achievement\Requests\ObjectiveRequest;
use Azuriom\Plugin\Achievement\Services\HookService;

class ObjectiveController extends Controller
{
    protected HookService $hookService;

    public function __construct(HookService $hookService)
    {
        $this->hookService = $hookService;
    }

    public function index()
    {
        $objectives = Objective::with('roles')->orderByDesc('created_at')->paginate(15);

        return view('achievement::admin.objectives.index', ['objectives' => $objectives]);
    }

    public function create()
    {
        return view('achievement::admin.objectives.create', $this->getFormData());
    }

    public function store(ObjectiveRequest $request)
    {
        $objective = Objective::create($request->validated());

        if ($request->input('visibility') === 'role' && $request->has('visibility_roles')) {
            $objective->roles()->sync($request->input('visibility_roles'));
        }

        return redirect()->route('achievement.admin.objectives.index')
            ->with('success', trans('achievement::admin.objectives.status.created'));
    }

    public function edit(Objective $objective)
    {
        return view('achievement::admin.objectives.edit', array_merge(
            $this->getFormData(),
            ['objective' => $objective]
        ));
    }

    public function update(ObjectiveRequest $request, Objective $objective)
    {
        $objective->update($request->validated());

        if ($request->input('visibility') === 'role' && $request->has('visibility_roles')) {
            $objective->roles()->sync($request->input('visibility_roles'));
        } else {
            $objective->roles()->detach();
        }

        return redirect()->route('achievement.admin.objectives.index')
            ->with('success', trans('achievement::admin.objectives.status.updated'));
    }

    public function destroy(Objective $objective)
    {
        $objective->delete();

        return redirect()->route('achievement.admin.objectives.index')
            ->with('success', trans('achievement::admin.objectives.status.deleted'));
    }

    protected function getFormData(): array
    {
        $scratchGameEnabled = plugins()->isEnabled('scratch-game');
        $scratchCards = [];

        if ($scratchGameEnabled && function_exists('scratch_game_available_cards')) {
            $scratchCards = scratch_game_available_cards();
        }

        return [
            'hooks' => $this->getAvailableHooks(),
            'triggers' => $this->getAvailableTriggers(),
            'servers' => Server::executable()->get(),
            'roles' => Role::where('is_admin', false)->get(),
            'scratchGameEnabled' => $scratchGameEnabled,
            'scratchCards' => $scratchCards,
        ];
    }

    protected function getAvailableHooks(): array
    {
        $hooks = [];

        foreach (array_keys($this->hookService->getHooks()) as $hook) {
            $hooks[$hook] = ucfirst($hook);
        }

        return $hooks;
    }

    protected function getAvailableTriggers(): array
    {
        return $this->hookService->getHooks();
    }
}
