export function initModals() {
    // Gestion centralisée de l’ouverture/fermeture des modales,
    // pour édition d’un élément ou choix du type d’élément

    // // Popup pour choisir le type d’élément à ajouter
    // function showAddElementModal() {
    //     let html = '<div id="flibup_modal" class="flibup-modal">';
    //     html += '<div class="flibup-modal-content">';
    //     html += '<h3>Choisir le type d\'élément à ajouter</h3>';
    //     html += '<ul style="list-style:none;padding:0;">';
    //     elementTypes.forEach(function(et){
    //         html += `<li><button type="button" class="flibup-add-element-type button" data-type="${et.type}">${et.label}</button></li>`;
    //     });
    //     html += '</ul>';
    //     html += '<button type="button" class="button flibup-cancel-modal" style="margin-top:10px;">Annuler</button>';
    //     html += '</div></div>';
    //     document.body.insertAdjacentHTML('beforeend', html);

    //     // Events pour choix
    //     document.querySelectorAll('.flibup-add-element-type').forEach(btn=>{
    //         btn.addEventListener('click', function(){
    //             let type = this.getAttribute('data-type');
    //             addNewElement(type);
    //             closeModal();
    //         });
    //     });
    //     document.querySelector('.flibup-cancel-modal').addEventListener('click', closeModal);
    // }
    
    // function closeModal(){
    //     let modal = document.getElementById('flibup_modal');
    //     if (modal) modal.remove();
    // }
}
