(function ($, Drupal) {

  // Behaviors are triggered each time there is an AJAX call
  // Les Behaviors sont re-déclenchés à chaque appel AJAX
  Drupal.behaviors.myModuleBehavior = {

    // context holds information of the portion of the page beeing refreshed.
    // la variable context contient des informations sur la portion de la page rechargée.
    attach: function (context, settings) {

      var macy = Macy({
        container: '.images-wall',
        trueOrder: false,
        waitForImages: true,
        margin: 19,
        columns: 3,
      });
    }
  };
})(jQuery, Drupal);
