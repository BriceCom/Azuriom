@extends('admin.layouts.admin')
@section('title', 'Config - Theme Cesium')
@push('footer-scripts')
<script>

   function addLinkListener(el) {
       el.addEventListener('click', function () {
           const element = el.parentNode.parentNode.parentNode;

           element.parentNode.removeChild(element);
       });
   }

   document.querySelectorAll('.link-remove').forEach(function (el) {
       addLinkListener(el);
   });

   document.getElementById('addLinkButton').addEventListener('click', function () {
       const gen = Math.random();
       let input = '<div class="row"><div class="mb-3 col-md-6">';
       input += '<label class="form-label" for="footer_sublinks_linkname_'+gen+'">Lien</label><input type="text" placeholder="lien" id="footer_sublinks_linkname_'+gen+'" class="form-control" name="footer_sublinks[{index}][name]" required></div>';
       const gen2 = Math.random();
       input += '<div class="mb-3 col-md-6"><label class="form-label" for="footer_sublinks_url_'+gen2+'">URL</label><div class="input-group">';
       input += '<input id="footer_sublinks_url_'+gen2+'" type="url" placeholder="url" class="form-control" name="footer_sublinks[{index}][link]" required>';
       input += '<button class="btn btn-outline-danger link-remove" type="button">';
       input += '<i class="bi bi-x-lg"></i></button></div></div></div>';

       const newElement = document.createElement('div');
       newElement.innerHTML = input;

       addLinkListener(newElement.querySelector('.link-remove'));

       document.getElementById('links').appendChild(newElement);
   });

    document.getElementById('addLinkButton_1').addEventListener('click', function () {
         const gen = Math.random();
         let input = '<div class="row"><div class="mb-3 col-md-6">';
         input += '<label class="form-label" for="footer_links_1_linkname_'+gen+'">Lien</label><input type="text" placeholder="lien" id="footer_links_1_linkname_'+gen+'" class="form-control" name="footer_links_1[{index_1}][name]" required></div>';
         const gen2 = Math.random();
         input += '<div class="mb-3 col-md-6"><label class="form-label" for="footer_links_1_url_'+gen2+'">URL</label><div class="input-group">';
         input += '<input id="footer_links_1_url_'+gen2+'" type="url" placeholder="url" class="form-control" name="footer_links_1[{index_1}][link]" required>';
         input += '<button class="btn btn-outline-danger link-remove" type="button">';
         input += '<i class="bi bi-x-lg"></i></button></div></div></div>';

         const newElement = document.createElement('div');
         newElement.innerHTML = input;

         addLinkListener(newElement.querySelector('.link-remove'));

         document.getElementById('links_1').appendChild(newElement);
    });

    document.getElementById('addLinkButton_2').addEventListener('click', function () {
        const gen = Math.random();
         let input = '<div class="row"><div class="mb-3 col-md-6">';
         input += '<label class="form-label" for="footer_links_2_linkname_'+gen+'">Lien</label><input type="text" placeholder="lien" id="footer_links_2_linkname_'+gen+'" class="form-control" name="footer_links_2[{index_2}][name]" required></div>';
         const gen2 = Math.random();
         input += '<div class="mb-3 col-md-6"><label class="form-label" for="footer_links_2_url_'+gen2+'">URL</label><div class="input-group">';
         input += '<input id="footer_links_2_url_'+gen2+'" type="url" placeholder="url" class="form-control" name="footer_links_2[{index_2}][link]" required>';
         input += '<button class="btn btn-outline-danger link-remove" type="button">';
         input += '<i class="bi bi-x-lg"></i></button></div></div></div>';

         const newElement = document.createElement('div');
         newElement.innerHTML = input;

         addLinkListener(newElement.querySelector('.link-remove'));

         document.getElementById('links_2').appendChild(newElement);
    });


    document.getElementById('addLinkButton_3').addEventListener('click', function () {
        const gen = Math.random();
         let input = '<div class="row"><div class="mb-3 col-md-6">';
         input += '<label class="form-label" for="footer_links_3_linkname_'+gen+'">Lien</label><input type="text" placeholder="lien" id="footer_links_3_linkname_'+gen+'" class="form-control" name="footer_links_3[{index_3}][name]" required></div>';
         const gen2 = Math.random();
         input += '<div class="mb-3 col-md-6"><label class="form-label" for="footer_links_3_url_'+gen2+'">URL</label><div class="input-group">';
         input += '<input id="footer_links_3_url_'+gen2+'" type="url" placeholder="url" class="form-control" name="footer_links_3[{index_3}][link]" required>';
         input += '<button class="btn btn-outline-danger link-remove" type="button">';
         input += '<i class="bi bi-x-lg"></i></button></div></div></div>';

         const newElement = document.createElement('div');
         newElement.innerHTML = input;

         addLinkListener(newElement.querySelector('.link-remove'));

         document.getElementById('links_3').appendChild(newElement);
    });

   document.getElementById('configForm').addEventListener('submit', function () {
       let i = 0;

       document.getElementById('links').querySelectorAll('.row').forEach(function (el) {
           el.querySelectorAll('input').forEach(function (input) {
               input.name = input.name.replace('{index}', i.toString());
           });

           i++;
       });

       let g = 0;

         document.getElementById('links_1').querySelectorAll('.row').forEach(function (el) {
              el.querySelectorAll('input').forEach(function (input) {
                input.name = input.name.replace('{index_1}', g.toString());
              });

              g++;

            });

            let h = 0;

            document.getElementById('links_2').querySelectorAll('.row').forEach(function (el) {
                el.querySelectorAll('input').forEach(function (input) {
                  input.name = input.name.replace('{index_2}', h.toString());
                });

                h++;

              });

              let f = 0;

              document.getElementById('links_3').querySelectorAll('.row').forEach(function (el) {
                el.querySelectorAll('input').forEach(function (input) {
                  input.name = input.name.replace('{index_3}', f.toString());
                });

                f++;

              });

              // get and send footer desc





   });

</script>
<script src="{{ theme_asset('js/offercountdown.js') }}" defer></script>
@endpush

@section('content')
<form action="{{ route('admin.themes.config', $theme) }}" method="POST" id="configForm">
   @csrf
   <div class="p-0 container-fluid">
      <div class="row">
         <div class="col-md-3 col-xl-2">
         <div class="mb-4 shadow card">
                <div class="card-body">
                    <h4 class="card-title text-dark">Cesium <span class="badge bg-info">V0.0.8</span></h4>

                    <hr>

                    <h5 class="card-title text-dark">Auteur/Support</h5>
                     <a class="link" href="https://github.com/afi-dev" target="_blank">Afi</a>
                     <a class="link" href="mailto:aconique@gmail.com" target="_blank">Afi</a>

              <div>
              </div>

            </li>





                </div>
            </div>
            <div class="card">
               <div class="card-header">
                  <h5 class="mb-0 card-title text-primary">Configurations</h5>
               </div>
               <div class="list-group list-group-flush" role="tablist">
                  <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#pe0" role="tab" aria-selected="true">
                  Accueil
                  </a>
                  <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pe1" role="tab" aria-selected="true">
                  Footer
                  </a>
                  <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pe2" role="tab" aria-selected="false" tabindex="-1">
                  Statistiques
                  </a>
                  <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pe3" role="tab" aria-selected="false" tabindex="-1">
                  Discord
                  </a>
                  <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pe4" role="tab" aria-selected="false" tabindex="-1">
                  Offre du moment
                  </a>
                  <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pe5" role="tab" aria-selected="false" tabindex="-1">
                  Récomenses Votes
                  </a>
                  <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pe6" role="tab" aria-selected="false" tabindex="-1">
                     Liens Bannière
                  </a>
                  <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pe7" role="tab" aria-selected="false" tabindex="-1">
                  License
                  </a>
               </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
         </div>
         <div class="col-md-9 col-xl-10">
            <div class="tab-content ">
                <div class="tab-pane fade show active" id="pe0" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 card-title">Section 1</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="section1_title">Titre</label>
                                    <input type="text" class="form-control" id="section1_title" name="home[section1_title]" placeholder="Titre de la section 1" value="{{ theme_config('home.section1_title') }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="section1_img">Image <a href="/admin/images">Images</a></label>
                                    <input type="text" class="form-control" id="section1_img" name="home[section1_img]" placeholder="Image (e.g: discord.png)" value="{{ theme_config('home.section1_img') }}">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="section1_img_size">Taille image <a href="/admin/images">Images</a></label>
                                    <input type="number" list="large-img-size" class="form-control" id="section1_img_size" name="home[section1_img_size]" placeholder="Image (e.g: discord.png)" value="{{ theme_config('home.section1_img_size') }}">
                                </div>

                                <datalist id="large-img-size">
                                    <option value="100"></option>
                                    <option value="150"></option>
                                    <option value="200"></option>
                                    <option value="250"></option>
                                    <option value="300"></option>
                                </datalist>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="section1_color">Couleur de fond</label>
                                    <input type="color" class="form-control" id="section1_color" name="home[section1_color]" value="{{ theme_config('home.section1_color') }}">
                                </div>


                            </div>
                        </div>
                    </div><div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 card-title">Section 2</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="section2_title">Titre</label>
                                    <input type="text" class="form-control" id="section2_title" name="home[section2_title]" placeholder="Titre de la section 1" value="{{ theme_config('home.section2_title') }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="section2_img">Image <a href="/admin/images">Images</a></label>
                                    <input type="text" class="form-control" id="section2_img" name="home[section2_img]" placeholder="Image (e.g: discord.png)" value="{{ theme_config('home.section2_img') }}">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="section2_img_size">Taille image <a href="/admin/images">Images</a></label>
                                    <input type="number" list="large-img-size" class="form-control" id="section2_img_size" name="home[section2_img_size]" placeholder="Image (e.g: discord.png)" value="{{ theme_config('home.section2_img_size') }}">
                                </div>

                                <datalist id="large-img-size">
                                    <option value="100"></option>
                                    <option value="150"></option>
                                    <option value="200"></option>
                                    <option value="250"></option>
                                    <option value="300"></option>
                                </datalist>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="section2_color">Couleur de fond</label>
                                    <input type="color" class="form-control" id="section2_color" name="home[section2_color]" value="{{ theme_config('home.section2_color') }}">
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
               <div class="tab-pane fade" id="pe1" role="tabpanel">
                  <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Liens en bas du footer</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div id="links">
                              @foreach(theme_config('footer_sublinks') ?? [] as $link)
                              <div class="row g-3">
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_sublinks_linkname-{{ $loop->iteration }}">Lien</label>
                                    <input id="footer_sublinks_linkname-{{ $loop->iteration }}" type="text" class="form-control" placeholder="lien" name="footer_sublinks[{index}][name]" value="{{ $link['name'] }}" required>
                                 </div>
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_sublinks_url-{{ $loop->iteration }}">URL</label>
                                    <div class="input-group">
                                       <input id="footer_sublinks_url-{{ $loop->iteration }}" type="url" class="form-control" placeholder="url" name="footer_sublinks[{index}][link]" value="{{ $link['link'] }}" required>
                                       <button class="btn btn-outline-danger link-remove" type="button">
                                       <i class="bi bi-x-lg"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>
                        <button type="button" id="addLinkButton" class="btn btn-success">{{ trans('messages.actions.add') }}</button>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Liens footer 1</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div id="links_1">
                              @foreach(theme_config('footer_links_1') ?? [] as $link)
                              <div class="row g-3">
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_links_1_linkname-{{ $loop->iteration }}">Lien</label>
                                    <input id="footer_sublinks_linkname-{{ $loop->iteration }}" type="text" class="form-control" placeholder="lien" name="footer_sublinks[{index_1}][name]" value="{{ $link['name'] }}" required>
                                 </div>
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_links_1_url-{{ $loop->iteration }}">URL</label>
                                    <div class="input-group">
                                       <input id="footer_links_1_url-{{ $loop->iteration }}" type="url" class="form-control" placeholder="url" name="footer_sublinks[{index_1}][link]" value="{{ $link['link'] }}" required>
                                       <button class="btn btn-outline-danger link-remove" type="button">
                                       <i class="bi bi-x-lg"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>
                        <button type="button" id="addLinkButton_1" class="btn btn-success">{{ trans('messages.actions.add') }}</button>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Liens footer 2</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div id="links_2">
                              @foreach(theme_config('footer_links_2') ?? [] as $link)
                              <div class="row g-3">
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_links_2_linkname-{{ $loop->iteration }}">Lien</label>
                                    <input id="footer_sublinks_linkname-{{ $loop->iteration }}" type="text" class="form-control" placeholder="lien" name="footer_sublinks[{index_2}][name]" value="{{ $link['name'] }}" required>
                                 </div>
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_links_2_url-{{ $loop->iteration }}">URL</label>
                                    <div class="input-group">
                                       <input id="footer_links_2_url-{{ $loop->iteration }}" type="url" class="form-control" placeholder="url" name="footer_sublinks[{index_2}][link]" value="{{ $link['link'] }}" required>
                                       <button class="btn btn-outline-danger link-remove" type="button">
                                       <i class="bi bi-x-lg"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>
                        <button type="button" id="addLinkButton_2" class="btn btn-success">{{ trans('messages.actions.add') }}</button>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Liens footer 3</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div id="links_3">
                              @foreach(theme_config('footer_links_3') ?? [] as $link)
                              <div class="row g-3">
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_links_3_linkname-{{ $loop->iteration }}">Lien</label>
                                    <input id="footer_sublinks_linkname-{{ $loop->iteration }}" type="text" class="form-control" placeholder="lien" name="footer_sublinks[{index_3}][name]" value="{{ $link['name'] }}" required>
                                 </div>
                                 <div class="mb-3 col-md-6">
                                    <label class="form-label" for="footer_links_3_url-{{ $loop->iteration }}">URL</label>
                                    <div class="input-group">
                                       <input id="footer_links_3_url-{{ $loop->iteration }}" type="url" class="form-control" placeholder="url" name="footer_sublinks[{index_3}][link]" value="{{ $link['link'] }}" required>
                                       <button class="btn btn-outline-danger link-remove" type="button">
                                       <i class="bi bi-x-lg"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>
                        <button type="button" id="addLinkButton_3" class="btn btn-success">{{ trans('messages.actions.add') }}</button>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Description</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="mb-3 col-md-12">
                              <label class="form-label" for="desc_footer">Description du footer</label>
                              <textarea class="form-control" id="desc_footer" name="desc_footer" placeholder="Votre Description">{{ theme_config('desc_footer') }}</textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="pe2" role="tabpanel">
                  <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Nombre record de personnes connectées</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="mb-3 col-md-12">
                              <label class="form-label" for="record_co">Record de personnes connectées</label>
                              <input type="number" class="form-control" id="record_co" name="record_connection" placeholder="Record de personnes connectées" value="{{ theme_config('record_connection') }}">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="pe3" role="tabpanel">
               <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Embed Web Discord</h5>
                     </div>
                     <div class="card-body">
                     @php
    $discordLink = null;
    foreach(social_links() as $link) {
        if ($link->title == "Discord") {
            $discordLink = $link;

        }
    }
@endphp
@if (!$discordLink)
                     <div class="alert alert-danger" role="alert">Il semble que vous n'ayez pas configuré le réseau social Discord depuis Azuriom. Pour régler cela, cliquez simplement <a href="/admin/social-links">ici</a>, ajoutez Discord comme réseau social, copiez le lien d'invitation dans le champ "Valeur", puis enregistrez les changements. Une fois cela fait, vous pourrez ajuster les paramètres de l'embed dans cet espace.</div>
@endif
                        <div class="row">
                        @if ($discordLink)
                        <p class="mt-3 h5" >Status : @if (theme_config('discord_embed_enable') == 'true') <span class="badge bg-success">Activé</span> @else <span class="badge bg-danger">Désactivé</span> @endif</p>
                        @else
                        <p class="mt-3 h5" >Status : <span class="badge bg-danger">Désactivé</span></p>
                        @endif
                        @if ($discordLink)
                        <div class="mb-3 col-md-12">
	<label class="form-label" for="embed_discord_activate">Activer l'Embed Discord</label>

		<select class="form-select" id="embed_discord_activate" name="discord_embed_enable">
            <option selected value=@if (theme_config('discord_embed_enable') == 'true') "true" @else "false" @endif>Choisir</option>
            <option value="true">Activer</option>
            <option value="false">Desactiver</option>
        </select>

</div>
@endif
@if ($discordLink)
                           <div class="mb-3 col-md-12">
                              <label class="form-label" for="id_discord">ID du serveur Discord</label>
                              <input type="text" class="form-control" id="id_discord" placeholder="ID du serveur Discord" name="discord_embed_id" value="{{ theme_config('discord_embed_id') }}">
                           </div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="pe4" role="tabpanel">

               <div class="card">
										<div class="card-header">

											<h5 class="mb-0 card-title">Offre du moment</h5>
										</div>
										<div class="card-body">

                                            <div class="card">

<div class="px-4 pt-4 border card-header">

    <b>Offre en cours :</b>

    <p class="mt-3 h5" >Status : @if (theme_config('mount_offer_enable') == 'true') <span class="badge bg-success">Activé</span> @else <span class="badge bg-danger">Désactivé</span> @endif</p>
    <p class="mt-3 h5" >Temps restant :</p>
    @if (theme_config('mount_offer_enable') == 'true')
    <div class="px-2 py-2 my-2 bg-black badge" id="offer_countdown"  data-expiredate="{{ theme_config('mount_offer_end_date') }}T00:00" >Chargement...</div>
@else
    <div class="px-2 py-2 my-2 bg-black badge">Offre du mois désactivé</div>
    @endif
</div>


</div>
<div class="mb-3 col-md-12">
	<label class="form-label" for="offre_activate">Activer l'offre du moment</label>
		<select class="form-select" aria-label="Default select example" id="offre_activate" name="mount_offer_enable">
        <option selected value=@if (theme_config('mount_offer_enable') == 'true') "true" @else "false" @endif>Choisir</option>
            <option value="true">Activer</option>
            <option value="false">Desactiver</option>
        </select>
</div>

												<div class="row">
													<div class="mb-3 col-md-4">
														<label class="form-label" for="offre_name">Nom de l'offre</label>
														<input type="text" class="form-control" id="offre_name" placeholder="Offre (e.g: 100x Gems [EDITION LIMITÉ])" name="mount_offer_name" value="{{ theme_config('mount_offer_name') }}">
													</div>
													<div class="mb-3 col-md-4">
														<label class="form-label" for="offre_prix">Prix sans réduction</label>
														<input type="number" class="form-control" name="mount_offer_price" id="offre_prix" placeholder="Prix de base sans réduction" value="{{ theme_config('mount_offer_price') }}">
													</div>





													<div class="mb-3 col-md-4">
														<label class="form-label" for="offre_prix_reduc">Prix après réduction</label>
														<input type="number" class="form-control" name="mount_offer_price_reduction" placeholder="Prix après réduction" id="offre_prix_reduc" value="{{ theme_config('mount_offer_price_reduction') }}">
													</div>
													<div class="mb-3 col-md-4">
														<label class="form-label" for="offre_date">Date de fin de l'offre</label>
                                                        <input type="date" class="form-control" name="mount_offer_end_date" placeholder="Date de fin de l'offre" id="offre_date" value="{{ theme_config('mount_offer_end_date') }}">
													</div>
													<div class="mb-3 col-md-4">
														<label class="form-label" for="offre_link">Lien boutique vers l'offre</label>
														<input type="text" class="form-control" name="mount_offer_link" id="offre_link" placeholder="https://exemple.com" value="{{ theme_config('mount_offer_link') }}">
													</div>
                                                    <div class="mb-3 col-md-4">
														<label class="form-label" for="offre_link_type">Redirection</label>
														<select id="offre_link_type" name="mount_offer_link_type" class="form-select">
                                                            <option value="_blank">Nouvel onglet</option>
                                                            <option value="_self" selected>Sur le meme onglet</option>
                                                        </select>
													</div>
												</div>



										</div>
									</div>
               </div>
               <div class="tab-pane fade" id="pe5" role="tabpanel">
               <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Récompenses de Votes</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">

                           <div class="mb-3 col-md-6">
                              <label class="form-label" for="recompense_1er">Récompense mensuel du 1er</label>
                              <input type="number" name="vote_award_1" class="form-control" id="recompense_1er" placeholder="Nombre d'argent" value="{{ theme_config('vote_award_1') }}"></input>
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label" for="recompense_2eme">Récompense mensuel du 2eme</label>
                              <input type="number" name="vote_award_2" class="form-control" id="recompense_2eme" placeholder="Nombre d'argent" value="{{ theme_config('vote_award_2') }}"></input>
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label" for="recompense_3eme">Récompense mensuel du 3eme</label>
                              <input type="number" name="vote_award_3" class="form-control" id="recompense_3eme" placeholder="Nombre d'argent" value="{{ theme_config('vote_award_3') }}"></input>
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label" for="recompense_4eme">Récompense mensuel du 4eme</label>
                              <input type="number" name="vote_award_4" class="form-control" id="recompense_4eme" placeholder="Nombre d'argent" value="{{ theme_config('vote_award_4') }}"></input>
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label" for="recompense_5eme">Récompense mensuel du 5eme</label>
                              <input type="number" name="vote_award_5" class="form-control" id="recompense_5eme" placeholder="Nombre d'argent" value="{{ theme_config('vote_award_5') }}"></input>
                           </div>
                           <div>
                              <h1 class="mb-2 card-title">Récompense des autres votants</h1>
                              <div class="row">
                           <div class="mb-3 col-md-4">
                              <label class="form-label" for="recompense_all_enable">Activer/Descativer Récompenses Global</label>
                              <select name="vote_award_all" class="form-select" id="recompense_all_enable" placeholder="Activer/Desactiver la récompense mensuel global" value="{{ theme_config('vote_award_all_enable') }}">
                                 <option>Choisir</option>
                                 <option value="true">Activer</option>
                                 <option value="false">Desactiver</option>
                              </select>
                           </div>
                           <div class="mb-3 col-md-4">
                              <label class="form-label" for="recompense_all">Récompense mensuel des autres votants</label>
                              <input type="number" name="vote_award_all" class="form-control" id="recompense_all" placeholder="Nombre d'argent" value="{{ theme_config('vote_award_all') }}"></input>
                           </div>
                           <div class="mb-3 col-md-4">
                              <label class="form-label" for="recompense_all_image">Image de la récompense (<a href="/admin/images">Images</a>)</label>
                              <input type="text" name="vote_award_all_image" class="form-control" id="recompense_all_image" placeholder="Image (ex: coin.png)" value="{{ theme_config('vote_award_all_image') }}"></input>
                                          </diV>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               </div>
               <div class="tab-pane fade" id="pe6" role="tabpanel">
               <div class="card">
                     <div class="card-header">
                        <h5 class="mb-0 card-title">Liens dans la bannière Azuriom</h5>
                     </div>
                     <div class="card-body">
                        <div class="row">
                        <p class="mb-3 text-muted">Lien de gauche</p>
                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="title_header_link_left">Titre du Lien de Gauche</label>
                              <input type="text" class="form-control" id="title_header_link_left" name="title_header_link_left" placeholder="Titre Lien de Gauche (e.g: titre)" value="{{ theme_config('title_header_link_left') }}">
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="subtitle_header_link_left">Sous-Titre du Lien de Gauche</label>
                              <input type="text" class="form-control" id="subtitle_header_link_left" name="subtitle_header_link_left" placeholder="Sous-Titre Lien de Gauche (e.g: description)" value="{{ theme_config('subtitle_header_link_left') }}">
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="svg_link_left_banner">Image du Lien de Gauche <a href="/admin/images">Images</a></label>
                              <input type="text" class="form-control" id="svg_link_left_banner" name="img_header_link_left" placeholder="Image du Lien de Droite (e.g: discord.png)" value="{{ theme_config('img_header_link_left') }}">
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="link_header_link_left">Lien de Gauche</label>
                              <input type="text" class="form-control" id="link_header_link_left" name="link_header_link_left" placeholder="Lien de Gauche (e.g: https://google.com)" value="{{ theme_config('link_header_link_left') }}">
                              <p class="text-muted">Si vous mettez ! devant le lien, cela ouvrira le lien dans un nouvel onglet</p>
                           </div>
                        </div>


                        <div class="row">
                        <p class="mb-3 text-muted">Lien de droite</p>


                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="title_header_link_right">Titre du Lien de Droite</label>
                              <input type="text" class="form-control" id="title_header_link_right" name="title_header_link_right" placeholder="Titre Lien de Droite (e.g: titre)" value="{{ theme_config('title_header_link_right') }}">
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="subtitle_header_link_right">Sous-Titre du Lien de Droite</label>
                              <input type="text" class="form-control" id="subtitle_header_link_right" name="subtitle_header_link_right" placeholder="Sous-Titre Lien de Droite (e.g: description)" value="{{ theme_config('subtitle_header_link_right') }}">
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="svg_link_right_banner">Image du Lien de Droite (<a href="/admin/images">Images</a>)</label>
                              <input type="text" class="form-control" id="svg_link_right_banner" name="img_header_link_right" placeholder="Image du Lien de Droite (e.g: discord.png)" value="{{ theme_config('img_header_link_right') }}">
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label" for="link_header_link_right">Lien de Droite</label>
                              <input type="text" class="form-control" id="link_header_link_right" name="link_header_link_right" placeholder="Lien de Droite (e.g: https://google.com)" value="{{ theme_config('link_header_link_right') }}">
                              <p class="text-muted">Si vous mettez ! devant le lien, cela ouvrira le lien dans un nouvel onglet</p>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="pe7" role="tabpanel">
                  <div class="card">
                     <div class="card-body row">
                        <div class="mx-auto col-lg-9">
                           <div class="mt-6 alert alert-warning rounded-4" role="alert">
                              Veuillez lire attentivement les termes et conditions de cette licence. L'utilisation de ce contenu est soumise à des restrictions spécifiques qui exigent votre consentement et votre respect strict des dispositions énoncées ci-dessous.
                           </div>
                           <a href="{{ theme_asset('LICENSE.txt') }}" class="mt-3 btn btn-primary btn-lg">
                           LICENSE.txt
                           </a>
                           <div class="mt-3 mb-3 text-muted">Dernière modification : 13 novembre 2023</div>
                           <h2 class="h2">License Attribution-NoDerivatives 4.0 International</h2>
                           <p>Le theme "Cesium" est sous la license Creative Common Attribution-NoDerivatives 4.0 International CC BY-ND 4.0</p>
                           <hr class="my-4">
                           <h3 class="h3">Synthèse de la licence</h3>
                           <p class="mt-3">En vertu de la licence CC-BY-ND 4.0, vous êtes tenu de respecter les conditions suivantes. Le concédant ne peut retirer les permissions que vous octroi cette license tant que vous respectez scrupuleusement les termes de la licence.
                              <br><br><b>Vous êtes libre de :</b>
                           <ol class="mt-3">
                              <li>
                                 <p>Partager, copier et redistribuer le matériel sur n'importe quel support ou dans n'importe quel format, à n'importe quelle fin, même commerciale.</p>
                              </li>
                           </ol>
                           <b>Vous êtes soumis aux conditions suivantes :</b>
                           <ol class="mt-3">
                              <li>
                                 <p>Vous devez donner le crédit approprié, fournir un lien vers la licence et indiquer si des modifications ont été apportées. Vous pouvez le faire de toute manière raisonnable, mais pas d'une manière qui suggère que le donneur de licence vous approuve ou approuve votre utilisation.</p>
                              </li>
                              <li>
                                 <p>Si vous remixez, transformez ou développez le matériel, vous ne pouvez pas distribuer le matériel modifié.</p>
                              </li>
                              <li>
                                 <p>Vous ne pouvez pas appliquer de conditions juridiques ou de mesures technologiques qui empêchent légalement d'autres personnes de faire tout ce que la licence autorise.</p>
                              </li>
                           </ol>
                           <b>Exceptions :</b>
                           <ol class="mt-3">
                              <li>
                                 <p>Vous n'êtes pas tenu de respecter la licence pour les éléments du matériel relevant du domaine public ou lorsque votre utilisation est autorisée par une exception ou une limitation applicable.</p>
                              </li>
                           </ol>
                           <p class="mt-3">
                              Il est impératif que l'utilisateur comprenne et accepte de respecter rigoureusement les termes et conditions énoncés dans la licence CC-BY-ND 4.0. Tout manquement à ces conditions pourrait entraîner des poursuites légales, conformément aux dispositions de la licence. Le concédant se réserve le droit de prendre des mesures juridiques appropriées en cas de violation des termes énoncés dans la licence, afin de protéger ses droits et de garantir le respect de l'accord. Il est de la responsabilité de l'utilisateur de se familiariser avec les termes de la licence et de les observer scrupuleusement pour éviter toute conséquence juridique.
                           </p>
                           <hr class="my-4">
                           <h2 class="text-uppercase h1">License</h2>
                           <p>Creative Commons Corporation ("Creative Commons") is not a law firm and
                              does not provide legal services or legal advice. Distribution of
                              Creative Commons public licenses does not create a lawyer-client or
                              other relationship. Creative Commons makes its licenses and related
                              information available on an "as-is" basis. Creative Commons gives no
                              warranties regarding its licenses, any material licensed under their
                              terms and conditions, or any related information. Creative Commons
                              disclaims all liability for damages resulting from their use to the
                              fullest extent possible.
                           </p>
                           <p>Considerations for licensors: Our public licenses are
                              intended for use by those authorized to give the public
                              permission to use material in ways otherwise restricted by
                              copyright and certain other rights. Our licenses are
                              irrevocable. Licensors should read and understand the terms
                              and conditions of the license they choose before applying it.
                              Licensors should also secure all rights necessary before
                              applying our licenses so that the public can reuse the
                              material as expected. Licensors should clearly mark any
                              material not subject to the license. This includes other CC-
                              licensed material, or material used under an exception or
                              limitation to copyright. More considerations for licensors:
                              wiki.creativecommons.org/Considerations_for_licensors
                           </p>
                           <p>Considerations for the public: By using one of our public
                              licenses, a licensor grants the public permission to use the
                              licensed material under specified terms and conditions. If
                              the licensor's permission is not necessary for any reason--for
                              example, because of any applicable exception or limitation to
                              copyright--then that use is not regulated by the license. Our
                              licenses grant only permissions under copyright and certain
                              other rights that a licensor has authority to grant. Use of
                              the licensed material may still be restricted for other
                              reasons, including because others have copyright or other
                              rights in the material. A licensor may make special requests,
                              such as asking that all changes be marked or described.
                              Although not required by our licenses, you are encouraged to
                              respect those requests where reasonable. More considerations
                              for the public:
                              wiki.creativecommons.org/Considerations_for_licensees
                           </p>
                           <hr class="my-4">
                           <h2 class="text-uppercase h2" id="limitation-of-liabilities">Creative Commons Attribution-NoDerivatives 4.0 International Public License</h2>
                           <p>By exercising the Licensed Rights (defined below), You accept and agree
                              to be bound by the terms and conditions of this Creative Commons
                              Attribution-NoDerivatives 4.0 International Public License ("Public
                              License"). To the extent this Public License may be interpreted as a
                              contract, You are granted the Licensed Rights in consideration of Your
                              acceptance of these terms and conditions, and the Licensor grants You
                              such rights in consideration of benefits the Licensor receives from
                              making the Licensed Material available under these terms and
                              conditions.
                           </p>
                           <b class="mt-3">Section 1 - Definitions.</b>
                           <ol class="mt-3">
                              <li>
                                 <p>Adapted Material means material subject to Copyright and Similar
                                    Rights that is derived from or based upon the Licensed Material
                                    and in which the Licensed Material is translated, altered,
                                    arranged, transformed, or otherwise modified in a manner requiring
                                    permission under the Copyright and Similar Rights held by the
                                    Licensor. For purposes of this Public License, where the Licensed
                                    Material is a musical work, performance, or sound recording,
                                    Adapted Material is always produced where the Licensed Material is
                                    synched in timed relation with a moving image.
                                 </p>
                              </li>
                              <li>
                                 <p>Copyright and Similar Rights means copyright and/or similar rights
                                    closely related to copyright including, without limitation,
                                    performance, broadcast, sound recording, and Sui Generis Database
                                    Rights, without regard to how the rights are labeled or
                                    categorized. For purposes of this Public License, the rights
                                    specified in Section 2(b)(1)-(2) are not Copyright and Similar
                                    Rights.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Effective Technological Measures means those measures that, in the
                                    absence of proper authority, may not be circumvented under laws
                                    fulfilling obligations under Article 11 of the WIPO Copyright
                                    Treaty adopted on December 20, 1996, and/or similar international
                                    agreements.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Exceptions and Limitations means fair use, fair dealing, and/or
                                    any other exception or limitation to Copyright and Similar Rights
                                    that applies to Your use of the Licensed Material.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Licensed Material means the artistic or literary work, database,
                                    or other material to which the Licensor applied this Public
                                    License.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Licensed Rights means the rights granted to You subject to the
                                    terms and conditions of this Public License, which are limited to
                                    all Copyright and Similar Rights that apply to Your use of the
                                    Licensed Material and that the Licensor has authority to license.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Licensor means the individual(s) or entity(ies) granting rights
                                    under this Public License.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Share means to provide material to the public by any means or
                                    process that requires permission under the Licensed Rights, such
                                    as reproduction, public display, public performance, distribution,
                                    dissemination, communication, or importation, and to make material
                                    available to the public including in ways that members of the
                                    public may access the material from a place and at a time
                                    individually chosen by them.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Sui Generis Database Rights means rights other than copyright
                                    resulting from Directive 96/9/EC of the European Parliament and of
                                    the Council of 11 March 1996 on the legal protection of databases,
                                    as amended and/or succeeded, as well as other essentially
                                    equivalent rights anywhere in the world.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    You means the individual or entity exercising the Licensed Rights
                                    under this Public License. Your has a corresponding meaning.
                                 </p>
                              </li>
                           </ol>
                           <b class="mt-3">Section 2 - Scope.</b>
                           <ol class="mt-3">
                              <li>
                                 <p>
                                    License grant.
                                 </p>
                                 <ol class="mt-3">
                                    <li>
                                       <p>
                                          Subject to the terms and conditions of this Public License,
                                          the Licensor hereby grants You a worldwide, royalty-free,
                                          non-sublicensable, non-exclusive, irrevocable license to
                                          exercise the Licensed Rights in the Licensed Material to:
                                       </p>
                                       <ol class="mt-3">
                                          <li>
                                             <p>
                                                reproduce and Share the Licensed Material, in whole or in
                                                part, for NonCommercial purposes only; and
                                             </p>
                                          </li>
                                          <li>
                                             <p>
                                                produce and reproduce, but not Share, Adapted Material for
                                                NonCommercial purposes only.
                                             </p>
                                          </li>
                                       </ol>
                                    </li>
                                    <li>
                                       <p>
                                          Exceptions and Limitations. For the avoidance of doubt, where
                                          Exceptions and Limitations apply to Your use, this Public
                                          License does not apply, and You do not need to comply with
                                          its terms and conditions.
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          Term. The term of this Public License is specified in Section
                                          6(a).
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          Media and formats; technical modifications allowed. The
                                          Licensor authorizes You to exercise the Licensed Rights in all
                                          media and formats whether now known or hereafter created, and
                                          to make technical modifications necessary to do so. The
                                          Licensor waives and/or agrees not to assert any right or
                                          authority to forbid You from making technical modifications
                                          necessary to exercise the Licensed Rights, including
                                          technical modifications necessary to circumvent Effective
                                          Technological Measures. For purposes of this Public License,
                                          simply making modifications authorized by this Section 2(a)(4)
                                          never produces Adapted Material.
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          Downstream recipients.
                                       </p>
                                       <ol class="mt-3">
                                          <li>
                                             <p>
                                                Offer from the Licensor -- Licensed Material. Every recipient
                                                of the Licensed Material automatically receives an offer
                                                from the Licensor to exercise the Licensed Rights under
                                                the terms and conditions of this Public License.
                                             </p>
                                          </li>
                                          <li>
                                             <p>
                                                No downstream restrictions. You may not offer or impose any
                                                additional or different terms or conditions on, or apply
                                                any Effective Technological Measures to, the Licensed
                                                Material if doing so restricts exercise of the Licensed
                                                Rights by any recipient of the Licensed Material.
                                             </p>
                                          </li>
                                       </ol>
                                    </li>
                                    <li>
                                       <p>
                                          No endorsement. Nothing in this Public License constitutes or
                                          may be construed as permission to assert or imply that You
                                          are, or that Your use of the Licensed Material is, connected
                                          with, or sponsored, endorsed, or granted official status by,
                                          the Licensor or others designated to receive attribution as
                                          provided in Section 3(a)(1)(A)(i).
                                       </p>
                                    </li>
                                 </ol>
                              </li>
                              <li>
                                 <p>
                                    Other rights.
                                 </p>
                                 <ol class="mt-3">
                                    <li>
                                       <p>
                                          Moral rights, such as the right of integrity, are not licensed
                                          under this Public License, nor are publicity, privacy, and/or
                                          other similar personality rights; however, to the extent
                                          possible, the Licensor waives and/or agrees not to assert any
                                          such rights held by the Licensor to the limited extent
                                          necessary to allow You to exercise the Licensed Rights, but
                                          not otherwise.
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          Patent and trademark rights are not licensed under this Public
                                          License.
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          To the extent possible, the Licensor waives any right to collect
                                          royalties from You for the exercise of the Licensed Rights,
                                          whether directly or through a collecting society under any
                                          voluntary or waivable statutory or compulsory licensing
                                          scheme. In all other cases the Licensor expressly reserves
                                          any right to collect such royalties.
                                       </p>
                                    </li>
                                 </ol>
                              </li>
                           </ol>
                           <b class="mt-3">Section 3 - License Conditions.</b>
                           <p>Your exercise of the Licensed Rights is expressly made subject to the
                              following conditions.
                           </p>
                           <ol class="mt-3">
                              <li>
                                 <p>
                                    Attribution.
                                 </p>
                                 <ol class="mt-3">
                                    <li>
                                       <p>
                                          If You Share the Licensed Material, You must:
                                       </p>
                                       <ol class="mt-3">
                                          <li>
                                             <p>
                                                retain the following if it is supplied by the Licensor with the
                                                Licensed Material:
                                             </p>
                                             <ol class="mt-3">
                                                <li>
                                                   <p>
                                                      identification of the creator(s) of the Licensed Material and
                                                      any others designated to receive attribution, in any
                                                      reasonable manner requested by the Licensor (including
                                                      by pseudonym if designated);
                                                   </p>
                                                </li>
                                                <li>
                                                   <p>
                                                      a copyright notice;
                                                   </p>
                                                </li>
                                                <li>
                                                   <p>
                                                      a notice that refers to this Public License;
                                                   </p>
                                                </li>
                                                <li>
                                                   <p>
                                                      a notice that refers to the disclaimer of warranties;
                                                   </p>
                                                </li>
                                                <li>
                                                   <p>
                                                      a URI or hyperlink to the Licensed Material to the extent
                                                      reasonably practicable;
                                                   </p>
                                                </li>
                                             </ol>
                                          </li>
                                          <li>
                                             <p>
                                                indicate if You modified the Licensed Material and retain an
                                                indication of any previous modifications; and
                                             </p>
                                          </li>
                                          <li>
                                             <p>
                                                indicate the Licensed Material is licensed under this Public
                                                License, and include the text of, or the URI or hyperlink
                                                to, this Public License.
                                             </p>
                                          </li>
                                       </ol>
                                    </li>
                                    <li>
                                       <p>
                                          You may satisfy the conditions in Section 3(a)(1) in any reasonable
                                          manner based on the medium, means, and context in which You
                                          Share the Licensed Material. For example, it may be reasonable
                                          to satisfy the conditions by providing a URI or hyperlink to a
                                          resource that includes the required information.
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          If requested by the Licensor, You must remove any of the
                                          information required by Section 3(a)(1)(A) to the extent
                                          reasonably practicable.
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          If You Share Adapted Material You produce, the Adapter's License
                                          You apply must not prevent recipients of the Adapted Material
                                          from complying with this Public License.
                                       </p>
                                    </li>
                                 </ol>
                              </li>
                           </ol>
                           <b class="mt-3">Section 4 - Sui Generis Database Rights.</b>
                           <p>Where the Licensed Rights include Sui Generis Database Rights that
                              apply to Your use of the Licensed Material:
                           </p>
                           <ol class="mt-3">
                              <li>
                                 <p>
                                    for the avoidance of doubt, Section 2(a)(1) grants You the right
                                    to extract, reuse, reproduce, and Share all or a substantial
                                    portion of the contents of the database;
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    if You include all or a substantial portion of the database
                                    contents in a database in which You have Sui Generis Database
                                    Rights, then the database in which You have Sui Generis Database
                                    Rights (but not its individual contents) is Adapted Material,
                                    including for purposes of Section 3(b); and
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    You must comply with the conditions in Section 3(a) if You Share
                                    all or a substantial portion of the contents of the database.
                                 </p>
                              </li>
                           </ol>
                           <p>For the avoidance of doubt, this Section 4 supplements and does not
                              replace Your obligations under this Public License where the Licensed
                              Rights include other Copyright and Similar Rights.
                           </p>
                           <b class="mt-3">Section 5 - Disclaimer of Warranties and Limitation of Liability.</b>
                           <ol class="mt-3">
                              <li>
                                 <p>
                                    Unless otherwise separately undertaken by the Licensor, to the
                                    extent possible, the Licensor offers the Licensed Material as-is
                                    and as-available, and makes no representations or warranties of
                                    any kind concerning the Licensed Material, whether express,
                                    implied, statutory, or other. This includes, without limitation,
                                    warranties of title, merchantability, fitness for a particular
                                    purpose, non-infringement, absence of latent or other defects,
                                    accuracy, or the presence or absence of errors, whether or not
                                    known or discoverable. Where disclaimers of warranties are not
                                    allowed in full or in part, this disclaimer may not apply to You.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    To the extent possible, in no event will the Licensor be liable
                                    to You on any legal theory (including, without limitation,
                                    negligence) or otherwise for any direct, special, indirect,
                                    incidental, consequential, punitive, exemplary, or other losses,
                                    costs, expenses, or damages arising out of this Public License
                                    or use of the Licensed Material, even if the Licensor has been
                                    advised of the possibility of such losses, costs, expenses, or
                                    damages. Where a limitation of liability is not allowed in full
                                    or in part, this limitation may not apply to You.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    The disclaimer of warranties and limitation of liability provided
                                    above shall be interpreted in a manner that, to the extent
                                    possible, most closely approximates an absolute disclaimer and
                                    waiver of all liability.
                                 </p>
                              </li>
                           </ol>
                           <b class="mt-3">Section 6 - Term and Termination.</b>
                           <ol class="mt-3">
                              <li>
                                 <p>
                                    This Public License applies for the term of the Copyright
                                    and Similar Rights licensed here. However, if You fail to comply
                                    with this Public License, then Your rights under this Public
                                    License terminate automatically.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Where Your right to use the Licensed Material has terminated under
                                    Section 6(a), it reinstates:
                                 </p>
                                 <ol class="mt-3">
                                    <li>
                                       <p>
                                          automatically as of the date the violation is cured, provided it
                                          is cured within 30 days of Your discovery of the
                                          violation; or
                                       </p>
                                    </li>
                                    <li>
                                       <p>
                                          upon express reinstatement by the Licensor.
                                       </p>
                                    </li>
                                 </ol>
                                 <p>
                                    For the avoidance of doubt, this Section 6(b) does not affect any
                                    right the Licensor may have to seek remedies for Your violations
                                    of this Public License.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    For the avoidance of doubt, the Licensor may also offer the
                                    Licensed Material under separate terms or conditions or stop
                                    distributing the Licensed Material at any time; however, doing
                                    so will not terminate this Public License.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Sections 1, 5, 6, 7, and 8 survive termination of this Public
                                    License.
                                 </p>
                              </li>
                           </ol>
                           <b class="mt-3">Section 7 - Other Terms and Conditions.</b>
                           <ol class="mt-3">
                              <li>
                                 <p>
                                    The Licensor shall not be bound by any additional or different
                                    terms or conditions communicated by You unless expressly agreed.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Any arrangements, understandings, or agreements regarding the
                                    Licensed Material not stated herein are separate from and
                                    independent of the terms and conditions of this Public License.
                                 </p>
                              </li>
                           </ol>
                           <b class="mt-3">Section 8 - Interpretation.</b>
                           <ol class="mt-3">
                              <li>
                                 <p>
                                    For the avoidance of doubt, this Public License does not, and
                                    shall not be interpreted to, reduce, limit, restrict, or impose
                                    conditions on any use of the Licensed Material that could lawfully
                                    be made without permission under this Public License.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    To the extent possible, if any provision of this Public License is
                                    deemed unenforceable, it shall be automatically reformed to the
                                    minimum extent necessary to make it enforceable. If the provision
                                    cannot be reformed, it shall be severed from this Public License
                                    without affecting the enforceability of the remaining terms and
                                    conditions.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    No term or condition of this Public License will be waived and no
                                    failure to comply consented to unless expressly agreed to by the
                                    Licensor.
                                 </p>
                              </li>
                              <li>
                                 <p>
                                    Nothing in this Public License constitutes or may be interpreted
                                    as a limitation upon, or waiver of, any privileges and immunities
                                    that apply to the Licensor or You, including from the legal
                                    processes of any jurisdiction or authority.
                                 </p>
                              </li>
                           </ol>
                           <hr class="my-4">
                           <p>Creative Commons is not a party to its public
                              licenses. Notwithstanding, Creative Commons may elect to apply one
                              of its public licenses to material it publishes and in those
                              instances will be considered the “Licensor.” The text of the
                              Creative Commons public licenses is dedicated to the public domain
                              under the CC0 Public Domain Dedication. Except for the limited
                              purpose of indicating that material is shared under a Creative
                              Commons public license or as otherwise permitted by the Creative
                              Commons policies published at creativecommons.org/policies,
                              Creative Commons does not authorize the use of the trademark
                              "Creative Commons" or any other trademark or logo of Creative
                              Commons without its prior written consent including, without
                              limitation, in connection with any unauthorized modifications to
                              any of its public licenses or any other arrangements,
                              understandings, or agreements concerning use of licensed material.
                              For the avoidance of doubt, this paragraph does not form part of
                              the public licenses.
                           </p>
                           <b class="mt-3">Creative Commons may be contacted at creativecommons.org.</b>
                           <p class="mt-6">Attribution-NoDerivatives 4.0 International</p>
                        </div>
                     </div>
                              </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
   </div>
</form>
@endsection
