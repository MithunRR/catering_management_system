function addItemForm() {
  let addIF = document.getElementById('addItemForm');
  let addIFB = document.getElementById('addItemFormBtn');
  let addIFCB = document.getElementById('addItemFormCsBtn');
  addIF.style.display = 'block';
  addIFB.style.display = 'none';
  addIFCB.style.display = 'block';
}

function addItemFormHide() {
  let addIF = document.getElementById('addItemForm');
  let addIFB = document.getElementById('addItemFormBtn');
  let addIFCB = document.getElementById('addItemFormCsBtn');
  addIF.style.display = 'none';
  addIFB.style.display = 'block';
  addIFCB.style.display = 'none';
}

// function updateItemForm() {
//   let addIF = document.getElementById('updateItemForm');
//   let addIFB = document.getElementById('addItemFormBtn');
//   let addIFCB = document.getElementById('addItemFormCsBtn');
//   addIF.style.display = 'block';
//   addIFB.style.display = 'none';
//   addIFCB.style.display = 'none';
// }

// function cancelUpdateForm() {
//   let addIF = document.getElementById('updateItemForm');
//   let addIFB = document.getElementById('addItemFormBtn');
//   addIF.style.display = 'none';
//   addIFB.style.display = 'block';
// }

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateItemForm(itemId) {
  // Construct the ID of the update form based on the item ID
  let updateFormId = 'updateItemForm_' + itemId;

  // Hide all forms with IDs starting with 'updateItemForm_'
  let forms = document.querySelectorAll('[id^="updateItemForm_"]');
  forms.forEach(function (form) {
    form.style.display = 'none';
  });

  // Show the form for the clicked item
  let formToShow = document.getElementById(updateFormId);
  if (formToShow) {
    formToShow.style.display = 'block';
  }

  // Hide the 'Add Item' form and corresponding buttons
  let addIF = document.getElementById('addItemForm');
  let addIFB = document.getElementById('addItemFormBtn');
  let addIFCB = document.getElementById('addItemFormCsBtn');
  addIF.style.display = 'none';
  addIFB.style.display = 'block';
  addIFCB.style.display = 'none';
}

function cancelUpdateForm(itemId) {
  // Construct the ID of the update form based on the item ID
  let updateFormId = 'updateItemForm_' + itemId;

  // Hide the 'Update Item' form
  let updateForm = document.getElementById(updateFormId);
  if (updateForm) {
    updateForm.style.display = 'none';
  }

  // Show the 'Add Item' form and corresponding buttons
  let addIF = document.getElementById('addItemForm');
  let addIFB = document.getElementById('addItemFormBtn');
  let addIFCB = document.getElementById('addItemFormCsBtn');
  addIF.style.display = 'none';
  addIFB.style.display = 'block';
  addIFCB.style.display = 'none';
}
