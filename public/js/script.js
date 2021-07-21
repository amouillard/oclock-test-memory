$(document).ready(function () {
  var LANGUAGES = [ // Liste des cartes uniques disponibles
    'c',
    'cpp',
    'csharp',
    'go',
    'haskell',
    'html',
    'java',
    'javascript',
    'kotlin',
    'php',
    'python',
    'ruby',
    'swift',
    'typescript'
  ]
  var MAX_TIME = 120 // Temps imparti pour retourner toutes les cartes
  var FAIL_TIMEOUT = 1000 // Temps en cas d'échec (deux cartes différentes cliquées) où les cartes restent retournées

  var score = 0 // Le temps passé depuis le début du jeu, en secondes
  var pairsFound = 0 // Les paires correctement retournées
  var selectedPair = [] // Tableau qui va contenir les deux cartes retournées à vérifier
  var recentlyFailedTimeout = false // Timeout d'échec en cours
  var timer // Référence au timer de la barre de progression

  // C'est parti ! On affiche la popup du début, qui démarre le jeu au clic sur "démarrer"
  showDialog('#start-dialog')
  $('#start-button').click(function () {
    hideDialog()
    setup()
  })

  // Remise à zéro, on mélange les cartes, on remet en place les listeners de clic et on démarre la barre de progression
  function setup () {
    score = 0
    pairsFound = 0
    selectedPair = []
    resetBoard()
    setCardsListeners()
    resetProgressBar()
  }

  // Mélange et affichage des cartes
  function resetBoard () {
    // On duplique et mélange les langages pour en faire la liste des cartes
    var cards = LANGUAGES.concat(LANGUAGES)
    cards = shuffleArray(cards)

    var boardEl = $('#board')
    boardEl.empty()

    // On crée toutes les div pour chaque carte puis on les ajoute au board
    cards.forEach(function (language) {
      var cardEl = $(`
        <div class="card">
          <img class="card__logo" src="public/img/oclock-logo.png" alt="Logo carte memory">
        </div>
      `)
      // On stocke le nom du langage dans l'élément carte, il sera utilisé pour vérifier si deux cartes sont les mêmes
      cardEl.data({ lang: language })
      boardEl.append(cardEl)
    })
  }

  // Comportement au clic sur les cartes
  function setCardsListeners () {
    $('.card').on('click', function (e) {
      var clickedCardEl = $(e.currentTarget)

      // Si le joueur vient de retourner deux cartes différentes, le clic est bloqué pendant FAIL_TIMEOUT millisecondes
      if (recentlyFailedTimeout) {
        return
      }

      // Le joueur ne peut pas retourner à nouveau la première carte de la paire, ou une autre carte déjà retournée
      if (clickedCardEl.hasClass('flipped')) {
        return
      }

      // On retourne la carte cliquée et on stocke sa référence
      flipCard(clickedCardEl)
      selectedPair.push(clickedCardEl)

      // Si c'est la première carte retournée, il ne se passe plus rien d'autre
      if (selectedPair.length === 1) {
        return
      }

      // Si c'est la deuxième carte retournée, on vérifie si ce sont les deux mêmes, puis si le joueur a gagné
      if (checkSameCards(selectedPair)) {
        pairsFound++
        if (checkHasWon()) {
          win()
        }
        selectedPair = []
      } else { // Sinon c'est loupé
        recentlyFailedTimeout = true
        setTimeout(function () {
          flipCard(selectedPair[0])
          flipCard(selectedPair[1])
          recentlyFailedTimeout = false
          selectedPair = []
        }, FAIL_TIMEOUT)
      }
    })
  }

  function resetProgressBar () {
    var progressEl = $('#progress-bar')
    var timeleftEl = $('#time-left')

    // On stocke la date actuelle en millisecondes au démarrage du chrono
    var start = Date.now()

    clearInterval(timer)

    //Toutes les secondes, on vérifie avec une petite formule le pourcentage passé par rapport au temps max
    function setBarProgress () {
      var elapsedMilliseconds = Date.now() - start
      var elapsedSeconds = Math.floor(elapsedMilliseconds / 1000)
      var progressPercentage = (elapsedSeconds * 100) / MAX_TIME

      progressEl.attr('value', progressPercentage)
      timeleftEl.html(MAX_TIME - elapsedSeconds)

      score = elapsedSeconds // On met à jour le score qui est simplement le nombre de secondes écoulées

      // Si on atteint le temps limite, c'est perdu !
      if (progressPercentage >= 100) {
        lose()
      }
    }

    // On veut lancer la barre dès le clic sur "démarrer" et pas au bout d'une seconde, on appelle donc une
    // première fois la fonction puis on la passe au setInterval
    setBarProgress()
    timer = setInterval(setBarProgress, 1000)
  }

  // Bouton redémarrer dans la popup de défaite
  $('#restart-button').click(function () {
    setup()
    hideDialog()
  })

  // Retourne un booléen vérifiant si la paire de cartes contient les deux mêmes
  function checkSameCards (selectedPair) {
    return selectedPair[0].data('lang') === selectedPair[1].data('lang')
  }

  // Condition de victoire
  function checkHasWon () {
    return pairsFound === LANGUAGES.length
  }

  // Gagné ! :)
  function win () {
    clearInterval(timer)
    $('#score').html(score)
    $('#score-input').val(score)
    showDialog('#win-dialog')
  }

  // Perdu ! :(
  function lose () {
    clearInterval(timer)
    $('#pairs-found').html(pairsFound)
    showDialog('#lose-dialog')
  }

  // Retourne la carte en ajoutant/retirant une classe "flipped" et change le logo
  function flipCard (cardEl) {
    var flipped = cardEl.hasClass('flipped')
    var logoEl = cardEl.find('.card__logo')

    if (flipped) {
      cardEl.removeClass('flipped')
      logoEl.attr('src', 'public/img/oclock-logo.png')
    } else {
      cardEl.addClass('flipped')
      logoEl.attr('src', `public/img/lang/${cardEl.data('lang')}.png`)
    }
  }

  // Affiche une des popup
  function showDialog (name) {
    hideDialog()
    $('.dialog-background').show()
    $(name).show()
  }

  // Cache la popup
  function hideDialog () {
    $('.dialog-background').hide()
    $('.dialog-box').hide()
  }

  // Le petit bouton triche pour pouvoir tester plus facilement :)
  $('#cheat-button').click(function () {
    $('.cheat-text').remove()
    displayCheatText()
  })

  function displayCheatText () {
    $('.card').each(function (id, el) {
      $(el).html($(el).html() + `<span class="cheat-text" style="position: relative; bottom: 4px;">${$(el).data('lang')}</span>`)
    })
  }
})
