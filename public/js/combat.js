// elements (a declarer dans un autre fichier par la suite ) :
// const logDiv = document.getElementById('combatLog');



// Fonction pour lancer un dé
function rollDice(faces) {
    return Math.floor(Math.random() * faces) + 1;
}

// Ajouter un message au log
function addLog(message) {
    combat.log.push(message);
    
    const p = document.createElement('p');
    p.textContent = message;
    logDiv.appendChild(p);
    logDiv.scrollTop = logDiv.scrollHeight;
}

// maj interface
function updateUI() {
    // Stats
    //hero:
    heroPV.textContent = combat.hero.pv;
    heroMana.textContent = combat.hero.mana;
    
    // monstre :
    document.getElementById('monsterPV').textContent = combat.monster.pv;
    
    // desactiover le bouton magie si pas assez de mana
    if (btnMagic && combat.hero.mana < 3) {
        btnMagic.disabled = true;
        btnMagic.textContent = 'attaque Magique (pas assez de mana)';
    }
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

// Calcul attaque magique
function calculDegatMagique(defenseur, manaCost) {
    const armorBonus = 0;
    const attack = (rollDice(6) + rollDice(6)) + manaCost;
    const defense = rollDice(6) + Math.floor(defenseur.strength / 2) + armorBonus;
    return Math.max(0, attack - defense);
}

// Action du héros
function heroAction(action) {
    if (action === 'physical_attack') {
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
        
    } else if (action === 'use_potion') {
        addLog(`🧪 Vous utilisez une potion... (système à venir)`);
        // TODO: Implémenter le système de potions
    }
}

// action du monstre
function monstreAction() {
    const domages = calculDegatPhysique(combat.monster, combat.hero, false);
    combat.hero.pv -= domages;
    addLog(`${combat.monster.name} utilise ${combat.monster.attack} et vous infliges ${domages} points de dégats !`);
}

// Vérifier la fin du combat
function checkFinCombat() {
    if (combat.hero.pv <= 0) {
        // defaite
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
        const response = await fetch('../php/saveCombat.php', {
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
                chapter_id: combat.chapterId
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 3000);
        } else {
            alert('erreur sauvegarde : ' + data.error);
        }
        
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur de connexion au serveur', error);
    }
}

// un tour de combat
function executeTurn(action) {
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

