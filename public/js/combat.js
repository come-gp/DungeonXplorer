// Fonction pour lancer un dé
function rollDice(faces) {
    return Math.floor(Math.random() * faces) + 1;
}

// mettre un message dans le log
function addLog(message) {
    console.log('[LOG]', message);
    combat.log.push(message);
    
    if (!window.logDiv) {
        window.logDiv = document.getElementById('combatLog');
    }
    
    // if (!window.logDiv) {
    //     console.warn('logDiv n\'est pas initialisé!');
    //     return;
    // }
    
    const p = document.createElement('p');
    p.textContent = message;
    window.logDiv.appendChild(p);
    window.logDiv.scrollTop = window.logDiv.scrollHeight;
}

// Vérifier si le héros est mort et désactiver l'interface
function checkHeroDeath() {
    if (!combat || !combat.hero) {
        console.warn('Combat non initialisé');
        return false;
    }
    
    const isDead = combat.hero.pv <= 0;
    
    if (isDead) {
        
        // message de mort
        const deathAlert = document.getElementById('deathAlert');
        if (deathAlert) {
            deathAlert.style.display = 'block';
        }
        
        // on eneleve les boutons
        const combatActions = document.getElementById('combatActions');
        if (combatActions) {
            const buttons = combatActions.querySelectorAll('button');
            buttons.forEach(button => {
                button.disabled = true;
                button.style.opacity = '0.5';
                button.style.cursor = 'not-allowed';
            });
        }
        
        // on enleve les choix
        const choiceButtons = document.querySelectorAll('button[type="submit"]');
        choiceButtons.forEach(button => {
            if (!button.classList.contains('btn-close') && !button.id.includes('death')) {
                button.disabled = true;
                button.style.opacity = '0.5';
                button.style.cursor = 'not-allowed';
            }
        });
        
        return true;
    }
    
    return false;
}

// maj interface
function updateUI() {
    // Debug
    // console.log('updateUI appelée - Hero PV:', combat.hero.pv, 'Monster PV:', combat.monster.pv);
    
    // sidebar hero
    const heroPVSidebarElement = document.getElementById('heroPVSidebar');
    console.log('heroPVSidebarElement trouvé:', heroPVSidebarElement);
    if (heroPVSidebarElement) {
        heroPVSidebarElement.textContent = combat.hero.pv;
        console.log('Hero PV mis à jour dans la sidebar à :', combat.hero.pv);
        // maj bar pv
        const heroHpBarSidebar = document.getElementById('heroHpBarSidebar');
        console.log('heroHpBarSidebar trouvé:', heroHpBarSidebar);
        if (heroHpBarSidebar) {
            const percentage = Math.max(0, (combat.hero.pv / combat.hero.maxPv) * 100);
            heroHpBarSidebar.setAttribute('style', 'width: ' + percentage + '% !important');
        } else {
            console.warn('heroHpBarSidebar non trouvé!');
        }
    } else {
        console.warn('heroPVSidebarElement non trouvé!');
    }
    
    // mana si possinble
    if (combat.hero.class === 'Magicien') {
        const heroManaElement = document.getElementById('heroManaSidebar');
        console.log('heroManaElement trouvé:', heroManaElement);
        if (heroManaElement) {
            heroManaElement.textContent = combat.hero.mana;
            // Mettre à jour la barre de mana
            const heroManaBars = document.getElementById('heroManaBarSidebar');
            if (heroManaBars) {
                const percentage = (combat.hero.mana / combat.hero.maxMana) * 100;
                heroManaBars.style.width = percentage + '%';
            }
        }
    }
    
    // maj bar et pv monstre
    const monsterPVElement = document.getElementById('monsterPV');
    console.log('monsterPVElement trouvé:', monsterPVElement);
    if (monsterPVElement) {
        monsterPVElement.textContent = combat.monster.pv;
        console.log('Monster PV mis à jour à :', combat.monster.pv);
    } else {
        console.warn('monsterPVElement non trouvé!');
    }
    const monsterHpBar = document.getElementById('monsterHpBar');
    console.log('monsterHpBar trouvé:', monsterHpBar);
    if (monsterHpBar) {
        const percentage = (combat.monster.pv / combat.monster.maxPv) * 100;
        monsterHpBar.setAttribute('style', 'width: ' + percentage + '% !important');
        console.log('Barre monstre mise à jour à :', percentage + '%');
    } else {
        console.warn('monsterHpBar non trouvé!');
    }
    
    // pas de bouton magie si pas assez de mana
    if (combat.hero.class === 'Magicien') {
        const btnMagic = document.getElementById('btnMagic');
        if (btnMagic && combat.hero.mana < 3) {
            btnMagic.disabled = true;
            btnMagic.textContent = 'attaque Magique (pas assez de mana)';
        }
    }
    
    checkHeroDeath();
}

// calcul attaque physique
function calculDegatPhysique(attaquant, defenseur, isHeroAttacking) {
    const arme = 0; //TODO
    const armure = 0;  // tood
    
    const attack = rollDice(6) + attaquant.strength + arme;
    
    let defense;
    if (!isHeroAttacking && combat.hero.class === 'Voleur') {
        // dans le cas ou on est unvoleur
        defense = rollDice(6) + Math.floor(combat.hero.initiative / 2) + armure;
    } else {
        defense = rollDice(6) + Math.floor(defenseur.strength / 2) + armure;
    }
    
    return Math.max(0, attack - defense);
}

//  attaque magique
function calculDegatMagique(defenseur, manaCost) {
    const attack = (rollDice(6) + rollDice(6)) + manaCost;
    const defense = rollDice(6) + Math.floor(defenseur.strength / 2);
    return Math.max(0, attack - defense);
}

// action  héros
function heroAction(action) {
    if (action === 'drink_potion') {
        if (potions.count <= 0) {
            return;
        }
        
        potions.count--;
        const healValue = potions.healValue;
        
        combat.hero.pv = Math.min(combat.hero.pv + healValue, combat.hero.maxPv);
        
        // side baar
        const heroPVSidebar = document.getElementById('heroPVSidebar');
        if (heroPVSidebar) {
            heroPVSidebar.textContent = combat.hero.pv;
        }
        const heroHpBarSidebar = document.getElementById('heroHpBarSidebar');
        if (heroHpBarSidebar) {
            const percentage = (combat.hero.pv / combat.hero.maxPv) * 100;
            heroHpBarSidebar.style.width = percentage + '%';
        }
        
        //  compteur potions 
        const potionCountElement = document.getElementById('potionCountBattle');
        console.log('potionCountElement trouvé:', potionCountElement);
        if (potionCountElement) {
            potionCountElement.textContent = potions.count;
            console.log('Compteur potion mis à jour à :', potions.count);
        } else {
            console.warn('potionCountBattle non trouvé!');
        }
        if (potions.count === 0) {
            const btnPotion = document.getElementById('btnPotion');
            if (btnPotion) btnPotion.disabled = true;
        }
        
        addLog('Vous buvez une potion et récupérez ' + healValue + ' PV!');
        
    } else if (action === 'physical_attack') {
        const domages = calculDegatPhysique(combat.hero, combat.monster, true);
        combat.monster.pv -= domages;
        addLog(`vous attaquez et infligez ${domages} points de degats !`);
        
    } else if (action === 'magic_attack' && combat.hero.class === 'Magicien') {
        const manaCost = 3;
        if (combat.hero.mana >= manaCost) {
            const domages = calculDegatMagique(combat.monster, manaCost);
            combat.monster.pv -= domages;
            combat.hero.mana -= manaCost;
            addLog(`vous lancez un sort et infligez ${domages} points de dégats magiques ! (Mana: -${manaCost})`);
        } else {
            addLog(`Pas assez de mana ! Vous attaquez physiquement à la place.`);
            const domages = calculDegatPhysique(combat.hero, combat.monster, true);
            combat.monster.pv -= domages;
            addLog(`Vous infligez ${domages} points de dégats.`);
        }
        
    } 
}

// action du monstre
function monstreAction() {
    const domages = calculDegatPhysique(combat.monster, combat.hero, false);
    combat.hero.pv -= domages;
    addLog(`${combat.monster.name} utilise ${combat.monster.attack} et vous infliges ${domages} points de dégats !`);
}




function checkFinCombat() {
    if (combat.hero.pv <= 0) {
        // defaite
        showGamePopup('Defaite...', `Vous avez été vaincu par ${combat.monster.name}.`, 'red', [{
            text: 'OK',
            class: 'btn btn-secondary',
            callback: () => {}
        }]);

        addLog(`defaite... Vous avez été vaincu par ${combat.monster.name}.`);
        finCombat('defaite');
        return true;
    }
    
    if (combat.monster.pv <= 0) {
        // vicoitrr
        addLog(`victoire Vous avez vaincu ${combat.monster.name} !`);
        addLog(`voud gagnez ${combat.monster.xp} points d'expérience.`);
        finCombat('victoire');
        return true;
    }
    
    return false;
}

//fin combat
async function finCombat(result) {
    document.getElementById('combatActions').style.display = 'none';
    
    // elems
    const resultDiv = document.getElementById('combatResult');
    const resultMessage = document.getElementById('resultMessage');
    const resultDetails = document.getElementById('resultDetails');
    
    // afficher le message de la fin
    if (result === 'victoire') {
        resultMessage.textContent = 'Victoire !';
        resultDetails.textContent = `Vous avez vaincu ${combat.monster.name} et gagné ${combat.monster.xp} XP.`;
    } else {
        resultMessage.textContent = 'Defaite...';
        resultDetails.textContent = `Vous avez été vaincu par ${combat.monster.name}.`;
    }
    
    resultDiv.style.display = 'block';
    
    // sauvegrde des resultats
    try {
        const response = await fetch('/DungeonXplorer/public/save-combat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                hero_id: combat.hero.id,
                result: result,
                xp_gained: result === 'victoire' ? combat.monster.xp : 0,
                hero_pv: Math.max(0, combat.hero.pv),
                hero_mana: combat.hero.mana,
                chapter_id: combat.chapterId,
                nbPotions : potions.count
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            setTimeout(() => {
                window.location.href = '/DungeonXplorer/public/game';
            }, 3000);
        } else {
            alert('erreur sauvegarde : ' + data.error);
        }
        
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur de connexion au serveur: ' + error.message);
    }
}

// un tour de combat
function executeTurn(action) {
    if (combat.hero.pv <= 0) {
        return;
    }
    
    combat.turn++;
    addLog(`\n--- Tour ${combat.turn} ---`);
    
    // calucul initiative
    const heroInitiative = rollDice(6) + combat.hero.initiative;
    const monstreInitiative = rollDice(6) + combat.monster.initiative;
    
    // determiner l'ordre (Voleur gagne quand egalite)
    const heroFirst = (heroInitiative > monstreInitiative) || (heroInitiative === monstreInitiative && combat.hero.class === 'Voleur');
    
    addLog(`initiative - Vous: ${heroInitiative} | ${combat.monster.name}: ${monstreInitiative}`);
    
    if (heroFirst) {
        addLog(`vous etes en premier !`);
        heroAction(action);
        
        if (!checkFinCombat() && combat.monster.pv > 0) {
            monstreAction();
            checkFinCombat();
        }
    } else {
        addLog(` ${combat.monster.name} est en premier !`);
        monstreAction();
        
        if (!checkFinCombat() && combat.hero.pv > 0) {
            heroAction(action);
            checkFinCombat();
        }
    }
    
    updateUI();
}

window.addEventListener('load', () => {
    console.log('Page chargée - Vérification de l\'état du héros');
    setTimeout(() => {
        checkHeroDeath();
    }, 100);
});