<x-admin.card title="Carousel">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[off]',
        'name' => trans('theme::admin.disable')
    ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]', 'placeholder' => 'Nos serveurs minecraft'])
    @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[description]', 'wysiwyg' => true, 'placeholder' => 'Tu apprécies notre travail ? Découvre tous nos projets :'])

    <x-admin.fieldset :title="'Projets'" class="flex-column">
        <div id="carousel-projects-input" data-listInput="true">
            @forelse(theme_config('home.carousel.projects') ?? [] as $index => $project)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Projet {{ $index + 1 }}</h5>
                            <button class="btn btn-outline-danger carousel-projects-remove" type="button">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        @include('admin.components.forms.text', [
                            'name' => 'Titre',
                            'id' => $id.'[projects]['.$index.'][title]',
                            'value' => $project['title'] ?? '',
                            'title' => 'WorldOfSkill'
                        ])
                        @include('admin.components.forms.textarea', [
                            'name' => 'Description',
                            'id' => $id.'[projects]['.$index.'][description]',
                            'value' => $project['description'] ?? '',
                            'placeholder' => 'Premier PvP/Cheat Français'
                        ])
                        @include('admin.components.forms.text', [
                            'name' => 'Adresse IP',
                            'id' => $id.'[projects]['.$index.'][ip]',
                            'value' => $project['ip'] ?? '',
                            'placeholder' => 'play.worldofskill.fr'
                        ])
                        @include('admin.components.forms.image-azuriom', [
                            'name' => 'Logo',
                            'id' => $id.'[projects]['.$index.'][logo]'
                        ])
                        @include('admin.components.forms.image-azuriom', [
                            'name' => 'Image de fond',
                            'id' => $id.'[projects]['.$index.'][bgImage]'
                        ])
                        @include('admin.components.forms.color', [
                            'name' => 'Couleur début',
                            'id' => $id.'[projects]['.$index.'][colorStart]',
                            'value' => $project['colorStart'] ?? '#9C0C0F'
                        ])
                        @include('admin.components.forms.color', [
                            'name' => 'Couleur fin',
                            'id' => $id.'[projects]['.$index.'][colorEnd]',
                            'value' => $project['colorEnd'] ?? '#DC4C4F'
                        ])
                    </div>
                </div>
            @empty
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Projet 1</h5>
                            <button class="btn btn-outline-danger carousel-projects-remove" type="button">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        @include('admin.components.forms.text', [
                            'name' => 'Titre',
                            'id' => $id.'[projects][0][title]',
                            'title' => 'WorldOfSkill'
                        ])
                        @include('admin.components.forms.textarea', [
                            'name' => 'Description',
                            'id' => $id.'[projects][0][description]',
                            'placeholder' => 'Premier PvP/Cheat Français'
                        ])
                        @include('admin.components.forms.text', [
                            'name' => 'Adresse IP',
                            'id' => $id.'[projects][0][ip]',
                            'placeholder' => 'play.worldofskill.fr'
                        ])
                        @include('admin.components.forms.image-azuriom', [
                            'name' => 'Logo',
                            'id' => $id.'[projects][0][logo]'
                        ])
                        @include('admin.components.forms.image-azuriom', [
                            'name' => 'Image de fond',
                            'id' => $id.'[projects][0][bgImage]'
                        ])
                        @include('admin.components.forms.color', [
                            'name' => 'Couleur début',
                            'id' => $id.'[projects][0][colorStart]',
                            'value' => '#9C0C0F'
                        ])
                        @include('admin.components.forms.color', [
                            'name' => 'Couleur fin',
                            'id' => $id.'[projects][0][colorEnd]',
                            'value' => '#DC4C4F'
                        ])
                    </div>
                </div>
            @endforelse
        </div>

        <div class="my-3">
            <button type="button" id="carousel-projects-add-button" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }} Projet
            </button>
        </div>
    </x-admin.fieldset>

@push('footer-scripts')
<script>
    document.querySelectorAll('.carousel-projects-remove').forEach(function (el) {
        carouselAddListener(el);
    });

    function carouselAddListener(el) {
        el.addEventListener('click', function () {
            this.closest('.card').remove();
        });
    }

    document.getElementById('carousel-projects-add-button').addEventListener('click', function () {
        const existingElements = document.getElementById('carousel-projects-input').querySelectorAll('.card');
        const currentIndex = existingElements.length;

        const projectCard = `
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Projet ${currentIndex + 1}</h5>
                        <button class="btn btn-outline-danger carousel-projects-remove" type="button">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-control" name="{{ $id }}[projects][${currentIndex}][title]" placeholder="WorldOfSkill">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="{{ $id }}[projects][${currentIndex}][description]" placeholder="Premier PvP/Cheat Français"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse IP</label>
                        <input type="text" class="form-control" name="{{ $id }}[projects][${currentIndex}][ip]" placeholder="play.worldofskill.fr">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="{{ $id }}[projects][${currentIndex}][logo]">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image de fond</label>
                        <input type="file" class="form-control" name="{{ $id }}[projects][${currentIndex}][bgImage]">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Couleur début</label>
                        <input type="color" class="form-control" name="{{ $id }}[projects][${currentIndex}][colorStart]" value="#9C0C0F">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Couleur fin</label>
                        <input type="color" class="form-control" name="{{ $id }}[projects][${currentIndex}][colorEnd]" value="#DC4C4F">
                    </div>
                </div>
            </div>
        `;

        const newElement = document.createElement('div');
        newElement.innerHTML = projectCard;

        carouselAddListener(newElement.querySelector('.carousel-projects-remove'));

        document.getElementById('carousel-projects-input').appendChild(newElement);
    });
</script>
@endpush
</x-admin.card>
