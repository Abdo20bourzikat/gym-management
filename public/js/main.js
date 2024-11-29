function toggleMemberStatus(memberId, checkboxElement) {
    const isActive = checkboxElement.checked;
    const status = isActive ? 'active' : 'inactive';
    const confirmationMessage = isActive 
        ? "Êtes-vous sûr de vouloir activer ce membre ?" 
        : "Êtes-vous sûr de vouloir désactiver ce membre ?";

    // Confirm the action
    if (confirm(confirmationMessage)) {
        // AJAX request to update member status
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './updateMemberStatus.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Le statut du membre a été mis à jour avec succès');
                location.reload();

            }
        };
        xhr.send('id=' + memberId + '&status=' + status);
    } else {
        // Revert the checkbox state if the user cancels
        checkboxElement.checked = !isActive;
    }
}
