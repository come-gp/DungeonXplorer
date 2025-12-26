const logDiv = document.getElementById('combatLog');

// interface
const heroPV = document.getElementById('heroPV');
const heroMana = document.getElementById('heroMana');

const btnMagic = document.getElementById('btnMagic');

/**
 * Affiche un popup dans le style du jeu
 * @param {string} title - Titre du popup
 * @param {string} message - Message/contenu du popup
 * @param {string} type - Type: 'info' (bleu), 'success' (vert), 'warning' (jaune), 'danger' (rouge), 'gold' (doré)
 * @param {Array<{text: string, callback: function, class: string}>} buttons - Boutons avec callbacks
 */
function showGamePopup(title, message, type = 'info', buttons = null) {
    // Créer le container du modal
    const modalId = 'gamePopup_' + Date.now();
    
    let borderColor = '#4A90E2'; // info
    if (type === 'success') borderColor = '#4A7A66';
    else if (type === 'warning') borderColor = '#FFB347';
    else if (type === 'danger') borderColor = '#8B1E1E';
    else if (type === 'gold') borderColor = '#C4975E';
    
    // Créer le HTML du modal
    let buttonsHtml = '';
    if (buttons && buttons.length > 0) {
        buttons.forEach((btn, index) => {
            const btnClass = btn.class || 'btn-primary';
            const btnId = `popupBtn_${index}_${Date.now()}`;
            buttonsHtml += `<button type="button" class="btn ${btnClass}" id="${btnId}" style="background-color: ${borderColor}; color: #1A1A1A; font-weight: 600; border: none;">${btn.text}</button>`;
        });
    } else {
        buttonsHtml = `<button type="button" class="btn btn-primary" id="popupCloseBtn_${Date.now()}" style="background-color: ${borderColor}; color: #1A1A1A; font-weight: 600; border: none;" data-bs-dismiss="modal">Fermer</button>`;
    }
    
    const modalHtml = `
    <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #2E2E2E; border: 2px solid ${borderColor};">
                <div class="modal-header" style="background-color: #1A1A1A; border-bottom: 1px solid ${borderColor};">
                    <h5 class="modal-title" style="color: ${borderColor}; font-weight: bold;">
                        <i class="fas fa-star me-2"></i>${title}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: #E5E5E5; line-height: 1.6;">
                    ${message}
                </div>
                <div class="modal-footer" style="background-color: #1A1A1A; border-top: 1px solid ${borderColor};">
                    ${buttonsHtml}
                </div>
            </div>
        </div>
    </div>
    `;
    
    // Ajouter le modal au DOM
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = modalHtml;
    document.body.appendChild(tempDiv.firstElementChild);
    
    // Initialiser le modal Bootstrap
    const modalElement = document.getElementById(modalId);
    const modal = new bootstrap.Modal(modalElement, { backdrop: 'static', keyboard: false });
    modal.show();
    
    // Ajouter les événements des boutons
    if (buttons && buttons.length > 0) {
        buttons.forEach((btn, index) => {
            const btnElement = document.getElementById(`popupBtn_${index}_${Date.now()}`);
            if (btnElement && btn.callback) {
                btnElement.addEventListener('click', function() {
                    modal.hide();
                    btn.callback();
                    // Supprimer le modal du DOM après fermeture
                    setTimeout(() => modalElement.remove(), 500);
                });
            }
        });
    } else {
        // Nettoyer le DOM quand on ferme
        modalElement.addEventListener('hidden.bs.modal', function() {
            modalElement.remove();
        });
    }
    
    return modal;
}

// fin comnat

const resultDiv = document.getElementById('combatResult');
const resultMessage = document.getElementById('resultMessage');
const resultDetails = document.getElementById('resultDetails');