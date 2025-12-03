const conf = document.getElementById("conf");
const confText = document.getElementById("confText");

var currentIdDelete = null;

function deleteElement(e, name) {
   currentIdDelete = e.dataset.id
   confText.innerHTML = "Etes vous sur de vouloir suprimmer " + name;

   conf.classList.add("actif");

}

function cancelDelete() {
   conf.classList.remove("actif");
   currentIdDelete = null
}

function confDelete() {

   if (currentIdDelete == null) return

   window.location.href = URL + "?id=" + currentIdDelete
   conf.classList.remove("actif");
}