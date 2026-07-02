try {
    var dateArrivee = new Date(document.getElementById('offer_countdown').getAttribute('data-expiredate'));; // Remplacez cette date par votre date cible

    function mettreAJourCompteARebours() {
      var maintenant = new Date();
      var difference = dateArrivee - maintenant;
    
      if (difference <= 0) {
        document.getElementById('offer_countdown').innerHTML = '0j 0h 0m 0s';
      } else {
        var jours = Math.floor(difference / (1000 * 60 * 60 * 24));
        var heures = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        var secondes = Math.floor((difference % (1000 * 60)) / 1000);
        var compteARebours = jours + 'j ' + heures + 'h ' + minutes + 'm ' + secondes + 's ';
        document.getElementById('offer_countdown').innerHTML = compteARebours;
        setTimeout(mettreAJourCompteARebours, 1000);
      }
    }
    
    mettreAJourCompteARebours();
} catch (e) {}