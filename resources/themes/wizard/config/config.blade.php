@extends('admin.layouts.admin')
@section('title', 'Thème Wizard')

@include('admin.elements.editor')

@section('content')
    @push('styles')
        <link href="{{ theme_asset('css/style-admin.css') }}" rel="stylesheet">
    @endpush
    @php
        $baseMenu  = [
                'global' => [
                    'is_enabled' => true,
                    'configs' => [
						[
                            'col' => 'col-lg-12',
                            'arrayItems' => [
                                'page' => 'global',
                                'pageTitle' => 'Barre de navigation',
                                'filedsBuilder' => [
                                    ['type' => 'text', 'key' => 'shop', 'value'=>'url', 'label' => 'Url de la boutique'],
                                ]
                            ]
                        ],
                    ]
                ],
                'home' => [
                    'is_enabled' => true,
                    'configs' => [
						[
                            'col' => 'col-lg-6',
                            'arrayItems' => [
                                'page' => 'home',
                                'pageTitle' => 'Hero',
                                'filedsBuilder' => [
                                    ['type' => 'images', 'key' => 'hero', 'value'=>'media', 'label' => 'Logo'],
                                    ['type' => 'text', 'key' => 'hero', 'value'=>'title', 'label' => 'Titre'],
                                    ['type' => 'text', 'key' => 'hero', 'value'=>'name_btn', 'label' => 'Nom du bouton'],
                                    ['type' => 'text', 'key' => 'hero', 'value'=>'ip_btn', 'label' => 'Ip du bouton']
                                ]
                            ]
                        ],
						[
                            'col' => 'col-lg-6',
                            'arrayItems' => [
                                'page' => 'home',
                                'pageTitle' => 'Qu\'est-ce que wizardMC ?',
                                'filedsBuilder' => [
                                    ['type' => 'images', 'key' => 'block_1', 'value'=>'back', 'label' => 'Image de fond'],
                                    ['type' => 'images', 'key' => 'block_1', 'value'=>'render', 'label' => 'Image du render'],
                                    ['type' => 'text', 'key' => 'block_1', 'value'=>'title', 'label' => "Qu'est-ce que wizardmc"],
                                    ['type' => 'textarea', 'key' => 'block_1', 'value'=>'description', 'label' => 'Description'],
                                ]
                            ]
                        ],
						[
                            'col' => 'col-lg-6',
                            'arrayItems' => [
                                'page' => 'home',
                                'pageTitle' => 'Derniers articles',
                                'filedsBuilder' => [
                                    ['type' => 'text', 'key' => 'article', 'value'=>'title', 'label' => 'Titre'],
                                    ['type' => 'images', 'key' => 'article', 'value'=>'back', 'label' => 'Image de fond'],
                                    ['type' => 'images', 'key' => 'article', 'value'=>'render', 'label' => 'Image du render'],
                                ]
                            ]
                        ],
                    ]
                ],'footer' => [
                    'is_enabled' => true,
                    'configs' => [
						[
                            'col' => 'col-lg-6',
                            'arrayItems' => [
                                'page' => 'footer',
                                'pageTitle' => 'Le site',
                                'filedsBuilder' => [
                                    ['type' => 'builderInputs', 'key' => 'site', 'labels' =>['Nom', 'Url'],
                                    'inputs' => [
                                        ['key' => 'site', 'value'=>'name', 'index' => 1],
                                        ['key' => 'site', 'value'=>'url', 'index' => 1],
                                    ]],
                                ]
                            ]
                        ],
						[
                            'col' => 'col-lg-6',
                            'arrayItems' => [
                                'page' => 'footer',
                                'pageTitle' => 'Statistiques',
                                'filedsBuilder' => [
                                    ['type' => 'text', 'key' => 'stats', 'value'=>'max-player', 'label' => 'Connectés max'],
                                ]
                            ]
                        ],
						[
                            'col' => 'col-lg-6',
                            'arrayItems' => [
                                'page' => 'footer',
                                'pageTitle' => 'CGV, CGU, Mentions légales',
                                'filedsBuilder' => [
                                    ['type' => 'builderInputs', 'key' => 'policy', 'labels' =>['Nom', 'Url'],
                                    'inputs' => [
                                        ['key' => 'policy', 'value'=>'name', 'index' => 1],
                                        ['key' => 'policy', 'value'=>'url', 'index' => 1],
                                    ]],
                                ]
                            ]
                        ],
                    ]
                ],
            ];
        $pluginMenu  = [
                'shop' => [
                    'is_enabled' => plugins()->isEnabled('shop'),
                    'configs' => [
						['col' => 'col-lg-6',
                            'arrayItems' => [
                                'page' => 'shop',
                                'pageTitle' => 'Catégories',
                                'filedsBuilder' => [
                                    ['type' => 'builderInputs', 'key' => 'multiplicateur', 'labels' =>['Nom de la catégorie', 'icone'],
                                    'inputs' => [
                                        ['key' => 'multiplicateur', 'value'=>'name', 'index' => 1],
                                        ['key' => 'multiplicateur', 'value'=>'icon', 'index' => 1],
                                    ]],
                                ]
                            ]
                        ],
                        ['col' => 'col-12',
                            'arrayItems' => [
                                'page' => 'shop',
                                'pageTitle' => 'Commandes',
                                'filedsBuilder' => [
                                    ['type' => 'builderInputs', 'key' => 'commandes', 'labels' =>['Nom', 'Grade-1', 'Grade-2', 'Grade-3', 'Grade-4'],
                                    'inputs' => [
                                        ['class'=> 'col-md-4','key' => 'commandes', 'value'=>'name', 'index' => 1],
                                        ['class'=> 'col-md-1','key' => 'commandes', 'value'=>'grade-1', 'index' => 1],
                                        ['class'=> 'col-md-1','key' => 'commandes', 'value'=>'grade-2', 'index' => 1],
                                        ['class'=> 'col-md-1','key' => 'commandes', 'value'=>'grade-3', 'index' => 1],
                                        ['class'=> 'col-md-1','key' => 'commandes', 'value'=>'grade-4', 'index' => 1],
                                    ]],
                                ]
                            ]
                        ],
                        ['col' => 'col-12',
                            'arrayItems' => [
                                'page' => 'shop',
                                'pageTitle' => 'Kits',
                                'filedsBuilder' => [
                                    ['type' => 'builderInputs', 'key' => 'kits', 'labels' =>['Nom', 'Grade-1', 'Grade-2', 'Grade-3', 'Grade-4'],
                                    'inputs' => [
                                        ['class'=> 'col-md-4', 'key' => 'kits', 'value'=>'name', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'kits', 'value'=>'grade-1', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'kits', 'value'=>'grade-2', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'kits', 'value'=>'grade-3', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'kits', 'value'=>'grade-4', 'index' => 1],
                                    ]],
                                ]
                            ]
                        ],
                        ['col' => 'col-12',
                            'arrayItems' => [
                                'page' => 'shop',
                                'pageTitle' => 'Divers',
                                'filedsBuilder' => [
                                    ['type' => 'builderInputs', 'key' => 'divers', 'labels' =>['Nom', 'Grade-1', 'Grade-2', 'Grade-3', 'Grade-4'],
                                    'inputs' => [
                                        ['class'=> 'col-md-4', 'key' => 'divers', 'value'=>'name', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'divers', 'value'=>'grade-1', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'divers', 'value'=>'grade-2', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'divers', 'value'=>'grade-3', 'index' => 1],
                                        ['class'=> 'col-md-1', 'key' => 'divers', 'value'=>'grade-4', 'index' => 1],
                                    ]],
                                ]
                            ]
                        ],
                    ]
                ],
                'vote' => [
                    'is_enabled' => plugins()->isEnabled('vote'),
                    'configs' => [
						['col' => 'col-lg-8',
                            'arrayItems' => [
                                'page' => 'vote',
                                'pageTitle' => 'Meilleurs voteurs',
                                'filedsBuilder' => [
                                    ['type' => 'text', 'key' => 'classement', 'value'=>'title', 'label' => 'Titre'],
                                    ['type' => 'textarea', 'key' => 'classement', 'value'=>'description', 'label' => 'Description'],
                                    ['type' => 'builderInputs', 'key' => 'classement', 'labels' =>['Récompense'],
                                    'inputs' => [
                                        ['key' => 'classement', 'value'=>'name', 'index' => 1],
                                    ]],
                                    ['type' => 'builderInputs', 'key' => 'multiplicateur', 'labels' =>['Multiplicateur'],
                                    'inputs' => [
                                        ['key' => 'multiplicateur', 'value'=>'name', 'index' => 1],
                                    ]],
                                ]
                            ]
                        ],
                    ]
                ]
            ];
            uasort($pluginMenu, function ($a, $b) {
                return $b['is_enabled'] <=> $a['is_enabled'];
            });

		    $menus =  $baseMenu + $pluginMenu;

            $counterPartial = 1;
            $allImagesStokage = \Azuriom\Models\Image::all();
            $navbars = \Azuriom\Models\NavbarElement::orderBy('position')
                ->get();
    @endphp

    @push('footer-scripts')
        <script src="{{ theme_asset('js/admin-config.js') }}" defer data-cfasync="false"></script>
        <script data-cfasync="false">
            document.querySelectorAll('[data-image-preview-select]').forEach(function (el) {
                imagePreviewSelect(el);
            });
            ////////////////////////////////////////////
            /////       Image Preview Select
            ////////////////////////////////////////////
            function imagePreviewSelect(el) {
                el.addEventListener('change', function () {
                    if (el.value) {
                        const reader = new FileReader();
                        const preview = document.getElementById(el.getAttribute('data-image-preview-select'));

                        preview.src = 'https://' + window.location.hostname + '/storage/img/' + el.value;
                        preview.classList.remove('d-none');

                        reader.onload = function (el) {
                            if (preview) {
                                preview.src = el.currentTarget.result;
                                preview.classList.remove('d-none');
                            }
                        };

                    }
                });
            }
        </script>
    @endpush

    <div class="row mb-5" id="accordion-theme">
        <div class="col-lg-2">
            <div class="list-group sticky-top">
                @foreach ( $menus as $key => $values)
                    @if(!$values['is_enabled'])
                        <span data-bs-toggle="tooltip" title="{{trans('theme::lang.plugin.requires')}}">
                      @endif
                     <button
                             class="list-group-item list-group-item-action list-group-item-light {{isset($values['multiple_page']) && $values['multiple_page'] ? 'multiple_page':''}} @if($loop->index == 0) active @endif"
                             title="{{$key}}"
                             href="#list-{{$key}}"
                             data-bs-toggle="list"
                             role="tab"
                             @if(!$values['is_enabled'])
                                 aria-disabled="false" disabled
                             @endif
                             aria-controls="{{$key}}">
                      {{trans('theme::lang.'.$key.'.title')}}
                         @if(isset($values['multiple_page']) && $values['multiple_page'])
                             <a
                                     class="px-3 float-right dropdown-toggle"
                                     type="button" id="dropdownMenu{{$key}}"
                                     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                             <div class="dropdown-menu" aria-labelledby="dropdownMenu{{$key}}">
                                    @foreach($values['multiple_page'] as $k => $v)
                                     <a class="dropdown-item {{$loop->index != 0 ? 'collapsed':''}}"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{$key}}-{{$k}}"
                                        @if($loop->index == 0) aria-expanded="true" @endif
                                        aria-controls="collapse{{$key}}-{{$k}}"><span>{{$v['name']}}</span></a>
                                 @endforeach
                                </div>
                         @endif
                     </button>

                            @if(!$values['is_enabled'])
                      </span>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-lg-10 mt-lg-0 mt-5 sidebar-dark">
            <form action="{{ route('admin.themes.config', $theme) }}" method="POST" id="configForm">
                @csrf
                <input type="hidden" name="project[color_themes]"
                       value="{{ old('project[color_themes]', config('theme.project.color_themes')) }}">
                <input type="hidden" name="project[color_themes_data]"
                       value="{{ old('project[color_themes_data]', config('theme.project.color_themes_data')) }}">

                <div class="tab-content" id="nav-tabContent">
                    @foreach ( $menus as $key => $values)
                        @if($values['is_enabled'])
                            <div
                                    class="tab-pane fade card shadow mb-4 pb-5 sortable {{ isset($values['multiple_page']) ? 'multi-page': 'not-multi-page'}} py-0 @if($loop->index == 0) active show @endif"
                                    id="list-{{$key}}" role="tabpanel"
                                    aria-labelledby="list-{{$key}}-list"
                            >
                                @includeIf("admin.config.$key", ['page_current' => $key, 'multiple_page'=> $values['multiple_page'] ?? ''])
                            </div>
                        @endif
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary"><i
                            class="fas fa-save"></i> {{ trans('messages.actions.save') }}</button>
            </form>
        </div>
    </div>
@endsection
