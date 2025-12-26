// variables de potions
let potions = {
    count: 0, // -> dans ke php
    healValue: 15
};

// compteur
function updatePotionDisplay() {
    const countElement = document.getElementById('potionCountBattle');
    if (countElement) {
        countElement.textContent = potions.count;
    }
    if (potions.count === 0) {
        const btnPotion = document.getElementById('btnPotion');
        if (btnPotion) btnPotion.disabled = true;
    }
}

//  boire une fonction
function drinkPotion() {
    if (potions.count <= 0) {
        addLog('Vous n\'avez pas de potion!');
        return;
    }

    // exec le tour
    executeTurn('drink_potion');
}

// c le addlog (je sais pas pouquoi on le remùet)
function addCombatLog(message) {
    const logElement = document.getElementById('combatLog');
    if (logElement) {
        const p = document.createElement('p');
        p.className = 'text-light mb-1';
        p.textContent = message;
        logElement.appendChild(p);
        logElement.scrollTop = logElement.scrollHeight;
    }
}

// init
function initializeHeroPVBars(maxPv) {
    // bare pv
    if (document.getElementById('heroHpBar')) {
        const heroPVElement = document.getElementById('heroPV');
        const heroMaxPVElement = document.getElementById('heroMaxPV');
        const heroHpBar = document.getElementById('heroHpBar');
        if (heroPVElement && heroMaxPVElement && heroHpBar) {
            const currentPV = parseInt(heroPVElement.textContent);
            const maxPVValue = parseInt(heroMaxPVElement.textContent);
            const percentage = (currentPV / maxPVValue) * 100;
            heroHpBar.style.width = percentage + '%';
        }
    }
    
    // init bar pv sidebar
    if (document.getElementById('heroHpBarSidebar')) {
        const heroPVSidebarElement = document.getElementById('heroPVSidebar');
        if (heroPVSidebarElement) {
            const currentPV = parseInt(heroPVSidebarElement.textContent);
            const percentage = (currentPV / maxPv) * 100;
            const heroHpBarSidebar = document.getElementById('heroHpBarSidebar');
            if (heroHpBarSidebar) {
                heroHpBarSidebar.style.width = percentage + '%';
            }
        }
    }
}

// quand la page est chargee (protection)
window.addEventListener('load', () => {
    updatePotionDisplay();
    // Les barres seront initialisées depuis game.php
});
