export function initElementsBuilder() {
    // Logique pour l’ajout, la suppression, la modification, le rendu de la liste d’éléments,
    // événements sur le bouton “Ajouter un élément”, édition, suppression, etc.
    // Utilise les helpers de modals.js pour afficher les formulaires.

     // --- Elements builder ---
    const elementsList = document.getElementById('flibup_elements_list');
    const addElementBtn = document.getElementById('flibup_add_element');
    const elementsInput = document.getElementById('flibup_elements');
    let elements = [];

    // Initialisation depuis la valeur cachée
    try { elements = JSON.parse(elementsInput.value) || []; } catch(e){ elements = []; }

    // Types disponibles
    const elementTypes = [
        {type: 'title', label: 'Titre'},
        {type: 'paragraph', label: 'Texte'},
        {type: 'button', label: 'Bouton'},
        {type: 'input', label: 'Champ (input)'},
        {type: 'image', label: 'Image'}
    ];

    function renderElementsList() {
        elementsList.innerHTML = '';
        if (elements.length === 0) {
            elementsList.innerHTML = '<em>Aucun élément ajouté pour l’instant.</em>';
            return;
        }
        elements.forEach(function(el, idx){
            let html = `<div class="flibup-element-item" data-idx="${idx}">`;
            html += `<strong>${elementTypes.find(e=>e.type===el.type)?.label || el.type}</strong>`;
            html += `<button type="button" class="flibup-edit-element button button-small" data-idx="${idx}">Modifier</button>
            <button type="button" class="flibup-delete-element button button-small" data-idx="${idx}">Supprimer</button>`;
            // Mini résumé visuel
            if (el.type === 'title' || el.type === 'paragraph') html += `<div style="margin-top:3px;">${el.text || ''}</div>`;
            if (el.type === 'button') html += `<div style="margin-top:3px;">Texte : ${el.text || ''}</div>`;
            if (el.type === 'input') html += `<div style="margin-top:3px;">Type : ${el.input_type || 'text'}</div>`;
            if (el.type === 'image') html += `<div style="margin-top:3px;">Image ID : ${el.media_id || ''}</div>`;
            html += `</div>`;
            elementsList.innerHTML += html;
        });
    }

    function addNewElement(type) {
        let newEl = {type};
        // Valeurs par défaut
        if (type === 'title' || type === 'paragraph') newEl.text = '';
        if (type === 'button') newEl.text = 'Mon bouton';
        if (type === 'input') newEl.input_type = 'text';
        if (type === 'image') newEl.media_id = '', newEl.src = '';
        elements.push(newEl);
        renderElementsList();
        updateHiddenInput();
        updatePreviewFromElements();
        editElement(elements.length-1); // Ouvre direct le formulaire
    }

    // Edition d’un élément
    elementsList.addEventListener('click', function(e){
        if (e.target.classList.contains('flibup-edit-element')) {
            editElement(Number(e.target.getAttribute('data-idx')));
        }
        if (e.target.classList.contains('flibup-delete-element')) {
            let idx = Number(e.target.getAttribute('data-idx'));
            elements.splice(idx,1);
            renderElementsList();
            updateHiddenInput();
            updatePreviewFromElements();
        }
    });

    function editElement(idx){
        const el = elements[idx];
        let html = '<div id="flibup_modal" class="flibup-modal"><div class="flibup-modal-content">';
        html += `<h3>Editer ${elementTypes.find(e=>e.type===el.type)?.label || el.type}</h3>`;
        // Champs selon type
        if (el.type === 'title' || el.type === 'paragraph') {
            html += `<label>Texte<br><input type="text" id="flibup_edit_text" value="${el.text || ''}" style="width:100%;"></label>`;
        }
        if (el.type === 'button') {
            html += `<label>Texte du bouton<br><input type="text" id="flibup_edit_text" value="${el.text || ''}" style="width:100%;"></label>`;
            html += `<label>URL (optionnel)<br><input type="text" id="flibup_edit_url" value="${el.url || ''}" style="width:100%;"></label>`;
        }
        if (el.type === 'input') {
            html += `<label>Type de champ<br>
            <select id="flibup_edit_input_type">
                <option value="text" ${el.input_type === 'text' ? 'selected' : ''}>Texte</option>
                <option value="email" ${el.input_type === 'email' ? 'selected' : ''}>Email</option>
                <option value="number" ${el.input_type === 'number' ? 'selected' : ''}>Nombre</option>
            </select></label>`;
            html += `<label>Placeholder<br><input type="text" id="flibup_edit_placeholder" value="${el.placeholder || ''}" style="width:100%;"></label>`;
        }
        if (el.type === 'image') {
            html += `<label>ID Média (à intégrer avec la médiathèque)<br><input type="text" id="flibup_edit_media_id" value="${el.media_id || ''}" style="width:100%;"></label>`;
            html += `<label>URL image<br><input type="text" id="flibup_edit_src" value="${el.src || ''}" style="width:100%;"></label>`;
            html += `<small>(Intégration avec la médiathèque à venir)</small>`;
        }
        html += '<div style="margin-top:10px;">';
        html += `<button type="button" class="button button-primary flibup-save-edit" data-idx="${idx}">Enregistrer</button> `;
        html += `<button type="button" class="button flibup-cancel-modal">Annuler</button>`;
        html += '</div></div></div>';
        document.body.insertAdjacentHTML('beforeend', html);

        // Events pour édition
        document.querySelector('.flibup-save-edit').addEventListener('click', function(){
            if (el.type === 'title' || el.type === 'paragraph' || el.type === 'button') {
                el.text = document.getElementById('flibup_edit_text').value;
            }
            if (el.type === 'button') {
                el.url = document.getElementById('flibup_edit_url').value;
            }
            if (el.type === 'input') {
                el.input_type = document.getElementById('flibup_edit_input_type').value;
                el.placeholder = document.getElementById('flibup_edit_placeholder').value;
            }
            if (el.type === 'image') {
                el.media_id = document.getElementById('flibup_edit_media_id').value;
                el.src = document.getElementById('flibup_edit_src').value;
            }
            elements[idx] = el;
            closeModal();
            renderElementsList();
            updateHiddenInput();
            updatePreviewFromElements();
        });
        document.querySelector('.flibup-cancel-modal').addEventListener('click', closeModal);
    }

    // Popup pour choisir le type d’élément à ajouter
    function showAddElementModal() {
        let html = '<div id="flibup_modal" class="flibup-modal">';
        html += '<div class="flibup-modal-content">';
        html += '<h3>Choisir le type d\'élément à ajouter</h3>';
        html += '<ul style="list-style:none;padding:0;">';
        elementTypes.forEach(function(et){
            html += `<li><button type="button" class="flibup-add-element-type button" data-type="${et.type}">${et.label}</button></li>`;
        });
        html += '</ul>';
        html += '<button type="button" class="button flibup-cancel-modal" style="margin-top:10px;">Annuler</button>';
        html += '</div></div>';
        document.body.insertAdjacentHTML('beforeend', html);

        // Events pour choix
        document.querySelectorAll('.flibup-add-element-type').forEach(btn=>{
            btn.addEventListener('click', function(){
                let type = this.getAttribute('data-type');
                addNewElement(type);
                closeModal();
            });
        });
        document.querySelector('.flibup-cancel-modal').addEventListener('click', closeModal);
    }
    
    function closeModal(){
        let modal = document.getElementById('flibup_modal');
        if (modal) modal.remove();
    }

    // --- Preview dynamique depuis éléments ---
    function updatePreviewFromElements() {
        const popup = document.querySelector('.flibup-popup');
        if (!popup) return;
        popup.innerHTML = `
            <button class="flibup-close" type="button" title="Fermer la popup">&times;</button>
            ${elements.map(el=>{
                if (el.type==='title') return `<h3>${escapeHtml(el.text)}</h3>`;
                if (el.type==='paragraph') return `<p>${escapeHtml(el.text)}</p>`;
                if (el.type==='button') return `<button class="flibup-btn">${escapeHtml(el.text)}</button>`;
                if (el.type==='input') return `<input type="${el.input_type}" placeholder="${escapeHtml(el.placeholder||'')}" class="flibup-input" />`;
                if (el.type==='image' && el.src) return `<img src="${escapeHtml(el.src)}" style="max-width:100%;border-radius:8px;">`;
                return '';
            }).join('')}
        `;
    }

    // --- Ajout d’un élément ---
    addElementBtn.addEventListener('click', showAddElementModal);

    // Initial rendering
    renderElementsList();
    updatePreviewFromElements();

}