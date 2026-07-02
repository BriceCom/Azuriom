<div class="card">
    <div class="card-header">
        <h5 class="card-title">Vote page</h5>
    </div>
    <div class="card-body">
        <div id="vote-rewards-container" class="mb-4">
            @foreach(theme_config('vote.rewards') ?? [] as $index => $reward)
                <div class="card mb-3 vote-reward-card border-secondary">
                    <div class="card-body p-0">
                        <div class="row align-items-end g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-hash me-2"></i>
                                        Position
                                    </label>
                                    <input type="text" class="form-control"
                                           name="vote[rewards][{{ $index }}][position]"
                                           placeholder="1"
                                           value="{{ $reward['position'] }}">
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        Reward
                                    </label>
                                    <input type="text" class="form-control"
                                           name="vote[rewards][{{ $index }}][reward]"
                                           placeholder="5 diamond"
                                           value="{{ $reward['reward'] }}">
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <button class="btn btn-outline-danger btn-sm vote-reward-remove w-100" type="button"
                                            title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="button" id="addVoteRewardButton" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>
                Add reward
            </button>
        </div>
    </div>
</div>
