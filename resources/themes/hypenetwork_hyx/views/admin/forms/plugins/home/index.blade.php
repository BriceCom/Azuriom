<div class="p-2 d-flex flex-column gap-5">

   <div class="w-100">
       <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
           <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Ip du serveur</legend>

           @include('admin.components.forms.text', [
                  'id' => $id.'[ip][text]',
                  'name' => "IP",
                  'placeholder' => "play.hypenetwork.fr"
              ])
       </fieldset>
   </div>

   <div class="d-flex flex-lg-row flex-column gap-4">
       <fieldset class="d-flex flex-column gap-3 border p-2 w-50">
           <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bloc texte et image du haut</legend>

           @include('admin.components.forms.switch', ['name' => 'Ne pas afficher', 'id' => $id.'[textimage-1][show]', 'direction' => 'row'])


           @include('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[textimage-1][imgUrl]'])


           @include('admin.components.forms.textaera', [
               'id' => $id.'[textimage-1][content]',
               'wysiwyg' => true,
               'name' => "Contenu",
           ])

           <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
               <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bouton</legend>
               @include('admin.components.forms.text', ['id' => $id.'[textimage-1][button][text]','name' => "Texte"])
               @include('admin.components.forms.text', ['id' => $id.'[textimage-1][button][url]','name' => "Lien", 'placeholder' => '#nos-serveurs ou un lien'])
           </fieldset>

           @include('admin.components.forms.switch', ['name' => 'Afficher le bouton pour rejoindre le serveur', 'id' => $id.'[textimage-1][joinButton]'])
       </fieldset>

       <fieldset class="d-flex flex-column gap-3 border p-2 w-50">
           <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bloc texte et image du bas</legend>

           @include('admin.components.forms.switch', ['name' => 'Afficher', 'id' => $id.'[textimage-2][show]', 'direction' => 'row'])


           @include('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[textimage-2][imgUrl]'])


           @include('admin.components.forms.textaera', [
               'id' => $id.'[textimage-2][content]',
               'wysiwyg' => true,
               'name' => "Contenu",
           ])

           <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
               <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bouton</legend>
               @include('admin.components.forms.text', ['id' => $id.'[textimage-2][button][text]','name' => "Texte"])
               @include('admin.components.forms.text', ['id' => $id.'[textimage-2][button][url]','name' => "Lien", 'placeholder' => '#nos-serveurs ou un lien'])
           </fieldset>

           @include('admin.components.forms.switch', ['name' => 'Afficher le bouton pour rejoindre le serveur', 'id' => $id.'[textimage-2][joinButton]'])
       </fieldset>
   </div>
</div>
