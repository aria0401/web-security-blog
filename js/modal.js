
// Setup delete confirmation for delete the article 
 
const deleteButton = document.querySelector('#deleteBtn');
const modal = document.querySelector(".myModal");
const confirmDelete = document.querySelector(".modal-delete");
const cancelDelete = document.querySelectorAll(".modal-cancel");

if (deleteButton) {
    deleteButton.addEventListener('click', e => {
        e.preventDefault();

    modal.style.display = "block";


    if(cancelDelete){
        cancelDelete.forEach(btn =>{
            btn.addEventListener("click", ()=>{
                modal.style.display = "none";
            })
        })
    }

    if(confirmDelete){
        confirmDelete.addEventListener('click', ()=>{
            const deleteForm = document.createElement('form');
 
                deleteForm.setAttribute('method', 'post');
                deleteForm.setAttribute('action', e.target.href);
                document.body.append(deleteForm);
                deleteForm.submit();
        })
    }

    });
}


